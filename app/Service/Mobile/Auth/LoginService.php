<?php

namespace App\Service\Mobile\Auth;

use App\Models\Customer\Customer;
use App\Traits\apiResponse;
use App\Traits\LoginActions;
use App\Traits\SendSms;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    use apiResponse, SendSms, LoginActions;

    public function login($request)
    {
        $request->validate([
            'phone'                  => 'required',
            'otp'                    => 'required',
        ]);

        $customer = Customer::where('phone', $request->phone)->where('otp', $request->otp)->first();

        if ($customer) {

            if ($customer->status == 0) {
                return $this->error(__('Account Is Not Active Please Contact Support Team'));
            }


            if ($token = auth('mobile')->login($customer)) {

                $customer->update(['otp' => null, 'otp_expired_at' => null]);

                // Add Daily Login Points
                $this->dailyLogin($customer);

                return $this->respondWithToken($token);
            }

        }

        return $this->error(__('Wrong Long Data'));
    }


    public function refresh()
    {
        if (auth('mobile')->user()) {

            return $this->respondWithToken(auth('mobile')->refresh());

        } else {

            return $this->error(__('token is invalid'));
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
