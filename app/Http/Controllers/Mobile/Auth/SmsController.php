<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Customer\OtpMail;
use App\Models\Customer\Customer;
use App\Traits\SendSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SmsController extends Controller
{

    use SendSms;


    public function otp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer) {   return $this->error(__('account not found')); }

        $otp = rand(10000, 99999);

        $otp = '12345';

        $customer->update(['otp' => $otp, 'otp_expired_at' => now()->addMinutes(10)]);

        $this->sendWhatsAppMessage($customer->phone, $otp);

        return response()->json([
            'otp'     => $otp,
            'message' =>  __('otp sent successfully')
        ]);
    }



}
