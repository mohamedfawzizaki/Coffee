<?php

use Illuminate\Support\Facades\Route;

include_once  __DIR__ . '/inc/auth.php';

include_once  __DIR__ . '/inc/general.php';



Route::middleware(['auth:mobile', 'mobile.active'])->group(function () {

    include_once  __DIR__ . '/inc/profile.php';

    include_once  __DIR__ . '/inc/core.php';

    include_once  __DIR__ . '/inc/order.php';


    include_once  __DIR__ . '/inc/finance.php';
});


