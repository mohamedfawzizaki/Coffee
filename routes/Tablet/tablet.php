<?php

use App\Http\Controllers\Tablet\Auth\AuthController;
use App\Http\Controllers\Tablet\Auth\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:tablet')->group(function () {

    Route::get('profile', [ProfileController::class, 'index']);

});
