<?php

use App\Http\Controllers\Cashier\Home\HomeController;
use App\Http\Controllers\Cashier\Menu\MenuController;
use App\Http\Controllers\Cashier\Order\OrderController;
use App\Http\Controllers\Cashier\Qr\QrCodeController;
use Illuminate\Support\Facades\Route;

Route::get('home', [HomeController::class, 'index']);

Route::post('changestatus', [HomeController::class, 'changeStatus']);

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
*/

Route::get('confirm/{id}', [OrderController::class, 'confirm']);

Route::get('ready/{id}/{type}', [OrderController::class, 'ready']);

Route::get('complete/{id}/{type}', [OrderController::class, 'complete']);

Route::get('cancel/{id}', [OrderController::class, 'cancel']);

Route::get('orders/{id}/{type}', [OrderController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Menu Routes
|--------------------------------------------------------------------------
*/

Route::get('menu', [MenuController::class, 'index']);

Route::post('menu/status', [MenuController::class, 'status']);


/*
|--------------------------------------------------------------------------
| Qr Routes
|--------------------------------------------------------------------------
*/

Route::post('qr/get', [QrCodeController::class, 'get']);

Route::post('qr/recieve', [QrCodeController::class, 'receive']);
