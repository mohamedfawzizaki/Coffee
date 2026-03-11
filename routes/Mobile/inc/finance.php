<?php

use App\Http\Controllers\Mobile\Finance\FinanceController;
use Illuminate\Support\Facades\Route;

Route::get('wallet', [FinanceController::class, 'wallet']);

Route::get('points', [FinanceController::class, 'points']);

