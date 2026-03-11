<?php

use App\Http\Controllers\Mobile\Order\CartController;
use App\Http\Controllers\Mobile\Order\CouponController;
use App\Http\Controllers\Mobile\Order\GiftCartController;
use App\Http\Controllers\Mobile\Order\GiftController;
use App\Http\Controllers\Mobile\Order\GiftOrderController;
use App\Http\Controllers\Mobile\Order\OrderController;
use App\Http\Controllers\Mobile\Order\PointReplaceController;
use Illuminate\Support\Facades\Route;

/*
    Cart Routes
*/

Route::prefix('cart')->group(function () {

    Route::get('/', [CartController::class, 'index']);

    Route::post('/', [CartController::class, 'store']);

    Route::post('/quantity-plus', [CartController::class, 'updateQuantityPlus']);

    Route::post('/quantity-minus', [CartController::class, 'updateQuantityMinus']);

    Route::post('/remove/{id}', [CartController::class, 'destroy']);

    Route::post('/empty', [CartController::class, 'destroyAll']);

    Route::post('/coupon', [CouponController::class, 'check']);

    Route::post('/coupon/apply', [CouponController::class, 'apply']);

    Route::delete('/delete-coupon', [CouponController::class, 'deleteCoupon']);

});

/*
    Order Routes
*/

Route::prefix('order')->group(function () {

    Route::post('/', [OrderController::class, 'store']);

    Route::get('/', [OrderController::class, 'index']);

    Route::get('/{id}', [OrderController::class, 'show']);

});


/*
    Gift Routes
*/

Route::prefix('gift')->group(function () {

    Route::post('/', [GiftController::class, 'store']);

    Route::get('/', [GiftController::class, 'index']);

    Route::get('/{id}', [GiftController::class, 'show']);

});


/* ============================================== */
/* ================== Gift Cart ================== */
/* ============================================== */


Route::prefix('gift-cart')->group(function () {

    Route::get('/', [GiftCartController::class, 'index']);

    Route::post('/', [GiftCartController::class, 'store']);

    Route::post('/remove/{id}', [GiftCartController::class, 'destroy']);

    Route::post('/empty', [GiftCartController::class, 'destroyAll']);

});

/* ============================================== */
/* ================== Gift Order ================== */
/* ============================================== */

Route::prefix('gift-order')->group(function () {

    Route::post('/', [GiftOrderController::class, 'store']);

    Route::get('/', [GiftOrderController::class, 'index']);

    Route::get('/{id}', [GiftOrderController::class, 'show']);

});



Route::post('/customer-check', [GiftOrderController::class, 'customerCheck']);

/* ============================================== */
/* ================== Point Replace ============ */
/* ============================================== */

Route::post('/points-replace', [PointReplaceController::class, 'store']);