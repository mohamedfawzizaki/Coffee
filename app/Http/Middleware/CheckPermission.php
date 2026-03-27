<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Map of route prefixes to permission modules.
     */
    protected $moduleMap = [
        // More specific prefixes should come first to avoid incorrect matches
        'dashboard.unregisteredcustomer' => 'customer',
        'dashboard.customer.wallet'      => 'finance',
        'dashboard.customer'             => 'customer',
        'dashboard.pointorder'           => 'order',
        'dashboard.point'                => 'customer',
        'dashboard.category-product'     => 'product',
        'dashboard.category'             => 'product',
        'dashboard.product'              => 'product',
        'dashboard.gifttransfer'         => 'order',
        'dashboard.gift'                 => 'order',
        'dashboard.abandoned'            => 'order',
        'dashboard.map'                  => 'order',
        'dashboard.report'               => 'order',
        'dashboard.transfer'             => 'finance',
        'dashboard.payment'              => 'finance',
        'dashboard.currency'             => 'finance',
        'dashboard.coupon'               => 'finance',
        'dashboard.marketing'            => 'marketing',
        'dashboard.contact'              => 'marketing',
        'dashboard.admin'                => 'admin',
        'dashboard.role'                 => 'admin',
        'dashboard.customercard'         => 'setting',
        'dashboard.birthday'             => 'setting',
        'dashboard.terms'                => 'setting',
        'dashboard.foodics-numbers'      => 'setting',
        'dashboard.foodics'              => 'setting',
        'dashboard.activity'             => 'setting',
        'dashboard.notifications'        => 'setting',
        'dashboard.search'               => 'setting',
        'dashboard.banner'               => 'setting',
        'dashboard.setting'              => 'setting',
        'dashboard.blog'                 => 'blog',
    ];

    /**
     * Map of route actions to permission types.
     */
    protected $actionMap = [
        'index'   => 'read',
        'show'    => 'read',
        'create'  => 'create',
        'store'   => 'create',
        'edit'    => 'update',
        'update'  => 'update',
        'delete'  => 'delete',
        'destroy' => 'delete',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin')->user();

        // Bypass if not an admin or if it's the superadmin (ID 1)
        if (!$user || $user->id == 1) {
            return $next($request);
        }

        $routeName = $request->route()->getName();
        if (!$routeName) {
            return $next($request);
        }

        // Special case for dashboard home
        if ($routeName === 'dashboard.') {
            if (!$user->isAbleTo('dashboard-read')) {
                abort(403);
            }
            return $next($request);
        }

        // Determine module and action from route name
        $module = null;
        foreach ($this->moduleMap as $prefix => $mod) {
            if (str_starts_with($routeName, $prefix)) {
                $module = $mod;
                break;
            }
        }

        if (!$module) {
            return $next($request);
        }

        $action = 'read'; // Default action
        foreach ($this->actionMap as $suffix => $act) {
            if (str_ends_with($routeName, '.' . $suffix)) {
                $action = $act;
                break;
            }
        }

        $permission = $module . '-' . $action;

        if (!$user->isAbleTo($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
