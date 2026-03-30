<?php

namespace App\Service\Mobile\Auth;

use App\Models\Customer\Customer;
use App\Models\CustomerCard\CustomerCard;
use App\Traits\apiResponse;
use App\Traits\LoginActions;
use App\Traits\SendSms;
use Illuminate\Support\Facades\Auth;

class RegisterService
{
    use apiResponse, SendSms, LoginActions;


    public function registerOtp($request)
    {
        $exists = Customer::where('phone', $request->phone)->exists();

        if ($exists) {
            return $this->error(__('Phone already exists'));
        }

        $otp = rand(10000, 99999);

        $otp = '12345';

       $sms =  $this->sendWhatsAppMessage($request->phone, $otp);

       if (!$sms) {   return $this->error(__('Failed to send OTP'));  }


       if(app()->locale == 'ar'){
         $message =  'رمز التحقق الخاص بك هو: ' . $otp . ' يرجى استخدامه لتسجيل الدخول في تطبيق كوفيماتكس وعدم مشاركته مع اي شخص.';
       } else {
        $message = 'Your verification code is ' . $otp . '. Please use it to log in to the Coffematics app and do not share it with anyone';
       }


        return response()->json([
            'otp'     => $otp,
            'message' => __('OTP sent successfully')
        ])  ;
    }

    // public function register($request)
    // {

    //    $customer =  Customer::create($request->validated());

    //    $card = CustomerCard::first();

    //    $customer->card_id = $card->id;

    //    $customer->save();

    //    // Add Register Points

    //    $this->registerPoints($customer);

    //    $this->registerFoodicsPoints($customer);


    //   $token = auth('mobile')->login($customer);

    //   return $this->respondWithToken($token);

    // }



    public function register($request)
    {
        try {
            $customer = \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
    
                $data = $request->validated();
                unset($data['referral_code']);
                $customer = Customer::create($data);
    
                $card = CustomerCard::first();
                if ($card) {
                    $customer->update([
                        'card_id' => $card->id
                    ]);
                }
    
                $this->registerPoints($customer);
                $this->registerFoodicsPoints($customer);

                if ($request->referral_code) {
                    $refered_customer = Customer::where('referral_code', $request->referral_code)->first();
                    if ($refered_customer) {
                        $this->registerReferralPoints($refered_customer);
                    }
                }
    
                return $customer;
            });
    
            $token = auth('mobile')->login($customer);
    
            return $this->respondWithToken($token);
    
        } catch (\Exception $e) {
    
            \Illuminate\Support\Facades\Log::error("Customer registration failed: " . $e->getMessage(), [
                'request' => $request->all()
            ]);
    
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    protected function respondWithToken($token)
    {

        return response()->json([
            'access_token'   => $token,
            'token_type'     => 'bearer',
            'expires_in'     =>  auth('mobile')->factory()->getTTL() * 60,
            'status'         =>  Auth::guard('mobile')->user()->status,

        ]);
    }


    public function generateReferralLink($request)
    {
        $customer = auth('mobile')->user();

        if ($customer->referral_code) {
            return response()->json([
                'message' => 'Referral code already generated',
                'referral_code' => $customer->referral_code,
            ]);
        }

        $referralCode = $this->generateUniqueReferralCode();

        $customer->update([
            'referral_code' => $referralCode
        ]);

        return response()->json([
            'message' => 'Referral code generated successfully',
            'referral_code' => $referralCode,
        ]);
    }

    private function generateUniqueReferralCode()
    {
        $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));

        if (Customer::where('referral_code', $code)->exists()) {
            return $this->generateUniqueReferralCode();
        }

        return $code;
    }
}
