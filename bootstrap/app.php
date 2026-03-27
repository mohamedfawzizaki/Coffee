<?php

// Suppress broken pipe notices from PHP built-in server
if (php_sapi_name() === 'cli-server') {
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {

            Route::middleware(['web', 'Dashboard', 'CheckPermission', 'localize', 'localizationRedirect', 'localeSessionRedirect', 'localeCookieRedirect', 'localeViewPath'])
            ->prefix(LaravelLocalization::setLocale())
            ->group(base_path('routes/Dashboard/dashboard.php'));

            Route::middleware(['api'])
                ->group(base_path('routes/webhook.php'));

           Route::middleware(['api'])
                ->prefix('mobile')
                ->group(base_path('routes/Mobile/mobile.php'));

            Route::middleware(['api'])
                ->prefix('cashier')
                ->group(base_path('routes/Cashier/cashier.php'));

            Route::middleware(['api'])
                ->prefix('tablet')
                ->group(base_path('routes/Tablet/tablet.php'));
    }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'Dashboard'               => \App\Http\Middleware\Dashboard::class,
            'mobile.active'           => \App\Http\Middleware\EnsureMobileCustomerIsActive::class,
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'CheckPermission'         => \App\Http\Middleware\CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {


    })->create();
