<?php

namespace App\Http\Controllers\Tablet\Auth;

use App\Http\Controllers\Controller;
use App\Service\Tablet\Auth\TabletAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private TabletAuthService $tabletAuthService){}


    /**
     * Login
     */
    public function login(Request $request)
    {
        return $this->tabletAuthService->login($request);
    }

}
