<?php

use App\Http\Controllers\Mobile\Core\BranchController;
use App\Http\Controllers\Mobile\Core\MenuController;
use App\Http\Controllers\Mobile\Home\HomeController;
use App\Http\Controllers\Mobile\Profile\FavouriteController;
use Illuminate\Support\Facades\Route;


/* ============================================== */
/* ================== Home ================== */
/* ============================================== */

Route::get('home', [HomeController::class, 'index']);

Route::get('customercards', [HomeController::class, 'customercards']);

/* ============================================== */
/* ================== Branches ================== */
/* ============================================== */

Route::get('branches', [BranchController::class, 'index']);

Route::get('branches/{id}', [BranchController::class, 'show']);

Route::post('branches-by-location', [BranchController::class, 'branchesByLocation']);


/* ============================================== */
/* ================== Menu ================== */
/* ============================================== */

Route::get('menu', [MenuController::class, 'index']);

Route::get('general-menu', [MenuController::class, 'generalMenu']);

Route::get('replace-menu', [MenuController::class, 'replaceMenu']);

Route::get('categories', [MenuController::class, 'categories']);

Route::get('category/{id}', [MenuController::class, 'category']);

Route::get('products', [MenuController::class, 'products']);

Route::get('product/{id}', [MenuController::class, 'product']);


/* ============================================== */
/* ================== Favourites ================== */
/* ============================================== */

Route::get('favourites', [FavouriteController::class, 'index']);

Route::post('favourites', [FavouriteController::class, 'toggle']);


