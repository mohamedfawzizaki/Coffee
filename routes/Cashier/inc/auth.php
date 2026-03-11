<?php

use App\Http\Controllers\Cashier\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);

