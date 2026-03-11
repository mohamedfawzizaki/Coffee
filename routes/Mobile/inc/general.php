<?php

use App\Http\Controllers\Mobile\General\GeneralController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\General\BlogController;
use App\Http\Controllers\Mobile\General\ContactController;

// Route::get('terms', [GeneralController::class, 'terms']);

Route::get('setting', [GeneralController::class, 'setting']);

Route::get('general-menu-v2', [GeneralController::class, 'menu']);

// Route::get('faq', [GeneralController::class, 'faq']);
