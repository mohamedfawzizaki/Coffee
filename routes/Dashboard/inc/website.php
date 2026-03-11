<?php

use App\Livewire\Dashboard\Website\Banner\BannerCreate;
use App\Livewire\Dashboard\Website\Banner\BannerEdit;
use App\Livewire\Dashboard\Website\Banner\BannerIndex;
use App\Livewire\Dashboard\Website\Blog\BlogCreate;
use App\Livewire\Dashboard\Website\Blog\BlogEdit;
use App\Livewire\Dashboard\Website\Blog\BlogIndex;
use App\Livewire\Dashboard\Website\Blog\BlogShow;
use App\Livewire\Dashboard\Website\Search\SearchIndex;
use Illuminate\Support\Facades\Route;




Route::prefix('blog')->name('blog.')->group(function () {

    Route::get('/', BlogIndex::class)->name('index');
    Route::get('/create', BlogCreate::class)->name('create');
    Route::get('/edit/{id}', BlogEdit::class)->name('edit');
    Route::get('/show/{id}', BlogShow::class)->name('show');

});


Route::prefix('banner')->name('banner.')->group(function(){

    Route::get('/', BannerIndex::class)->name('index');
    Route::get('/create', BannerCreate::class)->name('create');
    Route::get('/edit/{id}', BannerEdit::class)->name('edit');
 });


 Route::get('search', SearchIndex::class)->name('search.index');
