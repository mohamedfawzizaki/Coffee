<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Route::prefix('dashboard')->name('dashboard.')->group(function(){

    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });

    require_once __DIR__ . '/inc/auth.php';

    require_once __DIR__ . '/inc/general.php';

    require_once __DIR__ . '/inc/users.php';

    require_once __DIR__ . '/inc/setting.php';

    require_once __DIR__ . '/inc/product.php';

    require_once __DIR__ . '/inc/order.php';

    require_once __DIR__ . '/inc/finance.php';

    require_once __DIR__ . '/inc/website.php';


});
