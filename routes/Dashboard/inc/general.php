<?php

use App\Livewire\Dashboard\Foodics\FoodicsNumberIndex;
use App\Livewire\Dashboard\General\ActivityLog;
use App\Livewire\Dashboard\General\ContactIndex;
use App\Livewire\Dashboard\General\ContactShow;
use App\Livewire\Dashboard\General\Map\MapIndex;
use App\Livewire\Dashboard\General\NotificationIndex;
use App\Livewire\Dashboard\General\TermIndex;
use App\Livewire\Dashboard\Home\HomeIndex;
use App\Livewire\Dashboard\Report\ReportInbdex;
use App\Livewire\Dashboard\Report\CustomerOrderReport;
use App\Livewire\Dashboard\Report\MonthOrderReport;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeIndex::class);

Route::get('notifications', NotificationIndex::class)->name('notifications.index');

Route::get('activity', ActivityLog::class)->name('activity.index');

Route::get('map', MapIndex::class)->name('map.index');

Route::prefix('contact')->name('contact.')->group(function(){
    Route::get('/', ContactIndex::class)->name('index');
    Route::get('/show/{id}', ContactShow::class)->name('show');
    Route::delete('/delete/{id}', [ContactShow::class, 'delete'])->name('delete');
});


Route::get('report', ReportInbdex::class)->name('report.index');

Route::get('report/customer-orders', CustomerOrderReport::class)->name('report.customer-orders');

Route::get('report/month-orders', MonthOrderReport::class)->name('report.month-orders');

Route::get('terms', TermIndex::class)->name('terms.index');

Route::get('foodics-numbers', FoodicsNumberIndex::class)->name('foodics-numbers.index');
