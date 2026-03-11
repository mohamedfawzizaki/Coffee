<?php

use App\Livewire\Dashboard\Product\Category\CategoryProductOrder;
use App\Livewire\Dashboard\Product\Category\PcategoryCreate;
use App\Livewire\Dashboard\Product\Category\PcategoryEdit;
use App\Livewire\Dashboard\Product\Category\PcategoryIndex;
use App\Livewire\Dashboard\Product\Product\ProductCreate;
use App\Livewire\Dashboard\Product\Product\ProductEdit;
use App\Livewire\Dashboard\Product\Product\ProductIndex;
use App\Livewire\Dashboard\Product\Product\ProductShow;
use Illuminate\Support\Facades\Route;


Route::prefix('category')->name('category.')->group(function () {

    Route::get('/', PcategoryIndex::class)->name('index');

    Route::get('create', PcategoryCreate::class)->name('create');

    Route::get('edit/{id}', PcategoryEdit::class)->name('edit');


});


Route::prefix('product')->name('product.')->group(function () {

    Route::get('/', ProductIndex::class)->name('index');

    Route::get('show/{id}', ProductShow::class)->name('show');

    Route::get('create', ProductCreate::class)->name('create');

    Route::get('edit/{id}', ProductEdit::class)->name('edit');

});

Route::get('category-product', CategoryProductOrder::class)->name('category-product');

