<?php

use App\Livewire\Dashboard\Finance\Coupon\CouponCreate;
use App\Livewire\Dashboard\Finance\Coupon\CouponEdit;
use App\Livewire\Dashboard\Finance\Coupon\CouponIndex;
use App\Livewire\Dashboard\Finance\Currency\CurrencyEdit;
use App\Livewire\Dashboard\Finance\Currency\CurrencyIndex;
use App\Livewire\Dashboard\Finance\CustomerWallet;
use App\Livewire\Dashboard\Finance\ProviderWallet;
use App\Livewire\Dashboard\Finance\StoreWallet;
use App\Livewire\Dashboard\Finance\TransferIndex;
use App\Livewire\Dashboard\Payment\PaymentIndex;
use Illuminate\Support\Facades\Route;

Route::get('customerwallet', CustomerWallet::class)->name('customer.wallet');


Route::get('transfer', TransferIndex::class)->name('transfer.index');

Route::get('payment', PaymentIndex::class)->name('payment.index');


Route::prefix('currency')->name('currency.')->group(function(){

    Route::get('/', CurrencyIndex::class)->name('index');

    Route::get('/edit/{id}', CurrencyEdit::class)->name('edit');

});


Route::prefix('coupon')->name('coupon.')->group(function(){

    Route::get('/', CouponIndex::class)->name('index');

    Route::get('/create', CouponCreate::class)->name('create');

    Route::get('/edit/{id}', CouponEdit::class)->name('edit');

});
