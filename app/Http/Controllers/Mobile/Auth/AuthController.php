<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ToastNotification;
use App\Http\Requests\Mobile\Auth\RegisterRequest;
use App\Service\Mobile\Auth\LoginService;
use App\Service\Mobile\Auth\RegisterService;
use App\Traits\SendSms;

class AuthController extends Controller
{

    use SendSms;

   public function __construct(private RegisterService $registerService, private LoginService $loginService)
   {
        $this->registerService = $registerService;
        $this->loginService = $loginService;
   }

    public function login(Request $request)
    {

        return $this->loginService->login($request);
    }


    public function registerOtp(Request $request)
    {
        return $this->registerService->registerOtp($request);
    }

    public function register(RegisterRequest $request)
    {
        return $this->registerService->register($request);
    }

    public function generateReferralLink(Request $request)
    {
        return $this->registerService->generateReferralLink($request);
    }


    public function logout()
    {

        Auth::user()->update(['device_token' => null]);

        auth('mobile')->logout();

        return $this->success(__('logged out successfully'));
    }

    public function refresh()
    {

        return $this->loginService->refresh();

    }



}
