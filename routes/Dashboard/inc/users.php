<?php


// Providers

use App\Livewire\Dashboard\Customer\CustomerEdit;
use App\Livewire\Dashboard\Customer\CustomerIndex;
use App\Livewire\Dashboard\Customer\CustomerShow;
use App\Livewire\Dashboard\Admin\Admin\AdminCreate;
use App\Livewire\Dashboard\Admin\Admin\AdminEdit;
use App\Livewire\Dashboard\Admin\Admin\AdminIndex;
use App\Livewire\Dashboard\Admin\Role\RoleCreate;
use App\Livewire\Dashboard\Admin\Role\RoleEdit;
use App\Livewire\Dashboard\Admin\Role\RoleIndex;
use App\Livewire\Dashboard\Birthday\BirthdayIndex;
use App\Livewire\Dashboard\CustomerCard\CustomerCardCreate;
use App\Livewire\Dashboard\CustomerCard\CustomerCardEdit;
use App\Livewire\Dashboard\CustomerCard\CustomerCardIndex;
use App\Livewire\Dashboard\Point\PointIndex;
use App\Livewire\Dashboard\Unregistered\UnregisteredIndex;
use Illuminate\Support\Facades\Route;


// Customers

Route::prefix('customer')->name('customer.')->group(function () {

    Route::get('/', CustomerIndex::class)->name('index');

    Route::get('/show/{id}', CustomerShow::class)->name('show');

    Route::get('/edit/{id}', CustomerEdit::class)->name('edit');

});


// Unregistered Customers

Route::prefix('unregisteredcustomer')->name('unregisteredcustomer.')->group(function(){
    Route::get('/', UnregisteredIndex::class)->name('index');
});


// Birthdays

Route::prefix('birthday')->name('birthday.')->group(function(){

    Route::get('/', BirthdayIndex::class)->name('index');
});


// Roles

Route::prefix('role')->name('role.')->group(function(){

    Route::get('role', RoleIndex::class)->name('index');

    Route::get('role/create', RoleCreate::class)->name('create');

    Route::get('role/edit/{role}', RoleEdit::class)->name('edit');
});


// Admins

Route::prefix('admin')->name('admin.')->group(function(){

    Route::get('admin', AdminIndex::class)->name('index');

    Route::get('admin/create', AdminCreate::class)->name('create');

    Route::get('admin/edit/{admin}', AdminEdit::class)->name('edit');

});


// Customers Cards

Route::prefix('customercard')->name('customercard.')->group(function(){

    Route::get('/', CustomerCardIndex::class)->name('index');

    Route::get('/create', CustomerCardCreate::class)->name('create');

    Route::get('/edit/{id}', CustomerCardEdit::class)->name('edit');

});


// Points

Route::prefix('point')->name('point.')->group(function(){

    Route::get('/', PointIndex::class)->name('index');

    Route::get('/show/{id}', function($id){
        return view('livewire.dashboard.point.point-show', ['id' => $id]);
    })->name('show');
});
