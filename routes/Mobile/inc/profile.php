<?php

use App\Http\Controllers\Mobile\Profile\ProfileController;
use App\Http\Controllers\Mobile\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\General\GeneralController;
use App\Http\Controllers\Mobile\General\BlogController;
use App\Http\Controllers\Mobile\General\ContactController;

Route::get('profile', [ProfileController::class, 'index']);

Route::post('profile', [ProfileController::class, 'update']);

Route::post('updatetoken', [ProfileController::class, 'updatetoken']);

Route::post('logout', [AuthController::class, 'logout']);

Route::post('refresh', [AuthController::class, 'refresh']);

Route::post('update-fcm-token', [ProfileController::class, 'updateFcmToken']);

Route::get('notifications', [ProfileController::class, 'notifications']);

Route::post('deleteaccount', [ProfileController::class, 'deleteaccount']);


Route::get('blog', [BlogController::class, 'index']);

Route::get('blog/{id}', [BlogController::class, 'show']);

Route::post('contact', [ContactController::class, 'store']);

Route::get('contact', [ContactController::class, 'index']);