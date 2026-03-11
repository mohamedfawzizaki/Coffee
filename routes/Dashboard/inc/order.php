<?php

use App\Http\Controllers\Dashboard\InvoiceController;
use App\Livewire\Dashboard\Order\OrderIndex;
use App\Livewire\Dashboard\Order\OrderShow;
use App\Livewire\Dashboard\Gift\GiftIndex;
use App\Livewire\Dashboard\Gift\GiftShow;
use App\Livewire\Dashboard\GiftTransfer\GiftTransferIndex;
use App\Livewire\Dashboard\GiftTransfer\GiftTransferShow;
use App\Livewire\Dashboard\Order\Abandoned\AbandonedIndex;
use App\Livewire\Dashboard\Order\OrderEdit;
use App\Livewire\Dashboard\Order\Point\PointOrderIndex;
use App\Livewire\Dashboard\Order\Point\PointOrderShow;
use Illuminate\Support\Facades\Route;

Route::prefix('order')->name('order.')->group(function () {

    Route::get('/', OrderIndex::class)->name('index');

    Route::get('/show/{id}', OrderShow::class)->name('show');

    Route::get('/edit/{id}', OrderEdit::class)->name('edit');

    Route::get('/{id}/invoice', [InvoiceController::class, 'show'])->name('invoice');

});


Route::prefix('gift')->name('gift.')->group(function () {

    Route::get('/', GiftIndex::class)->name('index');

    Route::get('/show/{id}', GiftShow::class)->name('show');

});


Route::prefix('gifttransfer')->name('gifttransfer.')->group(function () {

    Route::get('/', GiftTransferIndex::class)->name('index');

    Route::get('/show/{id}', GiftTransferShow::class)->name('show');

});

Route::prefix('abandoned')->name('abandoned.')->group(function () {

    Route::get('/', AbandonedIndex::class)->name('index');

});


Route::prefix('pointorder')->name('pointorder.')->group(function () {

    Route::get('/', PointOrderIndex::class)->name('index');
    Route::get('/show/{id}', PointOrderShow::class)->name('show');
});
