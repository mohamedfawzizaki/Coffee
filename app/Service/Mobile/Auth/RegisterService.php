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
    
                $customer = Customer::create($request->validated());
    
                $card = CustomerCard::first();
                if ($card) {
                    $customer->update([
                        'card_id' => $card->id
                    ]);
                }
    
                $this->registerPoints($customer);
                $this->registerFoodicsPoints($customer);

                if ($request->referal_code) {
                    $refered_customer = Customer::find($request->referal_code);
                    if ($refered_customer) {
                        $this->registerReferalPoints($refered_customer);
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
}
