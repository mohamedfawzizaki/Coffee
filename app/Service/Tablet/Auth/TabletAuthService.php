<?php

namespace App\Service\Tablet\Auth;

use App\Models\Branch\TabletManger;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabletAuthService
{
    use apiResponse;

    public function login(Request $request)
    {
        $request->validate([
            'email'                  => 'required|email',
            'password'               => 'required',
        ]);


        if ($token = auth('tablet')->attempt($request->only('email', 'password'))) {

            return $this->respondWithToken($token);
        }

        return $this->error(__('Wrong Long Data'));
    }


    protected function respondWithToken($token)
    {

        return response()->json([
            'access_token'   => $token,
            'token_type'     => 'bearer',
            'expires_in'     =>  config('jwt.ttl') * 60,
            'status'         =>  Auth::guard('tablet')->user()->status,

        ]);
    }
}
