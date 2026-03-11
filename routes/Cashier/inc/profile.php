<?php

use App\Http\Controllers\Cashier\Auth\LoginController;
use App\Http\Controllers\Cashier\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('profile', [ProfileController::class, 'index']);

Route::post('profile', [ProfileController::class, 'update']);

Route::post('update-fcm-token', [ProfileController::class, 'updatetoken']);

Route::post('logout', [LoginController::class, 'logout']);

Route::post('refresh', [LoginController::class, 'refresh']);

Route::post('updatetoken', [ProfileController::class, 'updatetoken']);

Route::get('notifications', [ProfileController::class, 'notifications']);

Route::post('deleteaccount', [ProfileController::class, 'deleteaccount']);