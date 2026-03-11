<?php

namespace App\Http\Controllers\Cashier\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');


        if ($token = auth('cashier')->attempt($credentials)) {

            return $this->respondWithToken($token);
        }

        return $this->error(__('Invalid Credentials'));

    }

    protected function respondWithToken($token)
    {

        return response()->json([
            'access_token'   => $token,
            'token_type'     => 'bearer',
            'expires_in'     =>  auth('cashier')->factory()->getTTL() * 60,
            'status'         =>  Auth::guard('cashier')->user()->status,

        ]);
    }
}
