<?php

use App\Http\Controllers\Mobile\Auth\AuthController;
use App\Http\Controllers\Mobile\Auth\SmsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\General\GeneralController;

Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:mobile')->post('generate-referral-code', [AuthController::class, 'generateReferralLink']);

Route::post('register-otp', [AuthController::class, 'registerOtp']);

Route::post('generalotp', [SmsController::class, 'generalotp']);

Route::post('otp', [SmsController::class, 'otp']);

Route::post('registerotp', [SmsController::class, 'registerotp']);

Route::post('verify', [SmsController::class, 'verify']);


Route::get('terms', [GeneralController::class, 'terms']);

Route::get('setting', [GeneralController::class, 'setting']);

Route::get('faq', [GeneralController::class, 'faq']);
