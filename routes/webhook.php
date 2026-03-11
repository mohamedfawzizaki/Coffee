<?php

use App\Http\Controllers\Dummy\DummyController;
use App\Http\Controllers\Webhook\WebhookController;
use Illuminate\Support\Facades\Route;

// Route::get('/webhook/foodics', [WebhookController::class, 'store']);
// Route::get('/webhook/foodics', [DummyController::class, 'index']);

Route::post('/webhook/foodics', [WebhookController::class, 'webhook']);

Route::get('/webhook/orders', [DummyController::class, 'orders']);

Route::get('/webhook/branches', [DummyController::class, 'branches']);
