<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileCustomerIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $customer = auth('mobile')->user();

        if ($customer && (bool) ($customer->status ?? true) === false) {
            // Force client to remove token + re-login
            return response()->json([
                'message' => __('Account Is Not Active Please Contact Support Team'),
                'code'    => 'ACCOUNT_INACTIVE',
            ], 401);
        }

        return $next($request);
    }
}

