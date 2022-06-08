<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CountryController;
//use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\SubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('1.1')->group(function () {
    // Addresses
    Route::get('/addresses', [AddressController::class, 'index'])->name('api.address.index');
    Route::get('/addresses/geojson', [AddressController::class, 'geojson'])->name('api.address.geojson');
    Route::get('/addresses/search', [AddressController::class, 'search'])->name('api.address.search');
    Route::get('/addresses/{uuid}', [AddressController::class, 'show'])->name('api.address.show');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('api.category.index');
    Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('api.category.show');
    Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('api.subcategory.index');
    Route::get('/subcategories/{slug}', [SubcategoryController::class, 'show'])->name('api.subcategory.show');

    // Countries
    Route::get('/countries', [CountryController::class, 'index'])->name('api.country.index');
    Route::get('/countries/{cca3}', [CountryController::class, 'show'])->name('api.country.show');
});
