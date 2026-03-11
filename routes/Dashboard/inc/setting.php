<?php

use App\Livewire\Dashboard\Branch\BranchCreate;
use App\Livewire\Dashboard\Branch\BranchEdit;
use App\Livewire\Dashboard\Branch\BranchIndex;
use App\Livewire\Dashboard\Branch\BranchShow;
use App\Livewire\Dashboard\General\MarketingIndex;
use App\Livewire\Dashboard\General\SettingIndex;
use App\Livewire\Dashboard\PosManger\PosMangerCreate;
use App\Livewire\Dashboard\PosManger\PosMangerEdit;
use App\Livewire\Dashboard\PosManger\PosMangerIndex;
use App\Livewire\Dashboard\Profile\ProfileIndex;
use App\Livewire\Dashboard\Worktime\WorktimeEdit;
use Illuminate\Support\Facades\Route;

Route::get('marketing', MarketingIndex::class)->name('marketing.index');

// Settings

Route::get('setting', SettingIndex::class)->name('setting.index');

Route::get('profile', ProfileIndex::class)->name('profile.index');


Route::prefix('branch')->name('branch.')->group(function(){

    Route::get('/', BranchIndex::class)->name('index');

    Route::get('/edit/{id}', BranchEdit::class)->name('edit');

    Route::get('/show/{id}', BranchShow::class)->name('show');

});


Route::prefix('worktime')->name('worktime.')->group(function(){


    Route::get('/edit/{id}', WorktimeEdit::class)->name('edit');

});



Route::prefix('posmanager')->name('posmanager.')->group(function(){

    Route::get('/', PosMangerIndex::class)->name('index');

    Route::get('/create', PosMangerCreate::class)->name('create');

    Route::get('/edit/{id}', PosMangerEdit::class)->name('edit');

});
