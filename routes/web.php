<?php

use App\Http\Controllers\Dummy\DummyController;
use App\Http\Controllers\NEWNoonPaymentController;
use App\Http\Controllers\NoonPaymentController;
use App\Http\Controllers\Payment\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard.');
});




Route::get('dummy', [DummyController::class, 'index'])->name('dummy');

Route::get('test-notification', [DummyController::class, 'notification'])->name('test-notification');

Route::get('test-payment', [NoonPaymentController::class, 'index'])->name('test-payment');

Route::get('/payment_redirect', [PaymentController::class, 'index'])->name('payment_redirect');

Route::get('payment-success', function () {

    return response()->json([
        'message' => 'Payment Success'
    ]);

})->name('payment.success');

Route::get('payment-failed', function () {

    return response()->json([
        'message' => 'Payment Failed'
    ]);

})->name('payment.failed');
