<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Livewire\Address\{ CreateAddress, EditAddress, ListAddress, ShowAddress };
use App\Http\Livewire\Category\{ CreateCategory, EditCategory, ListCategory, ShowCategory };
use App\Http\Livewire\City\ShowCity;
use App\Http\Livewire\Country\{ ListCountry, ShowCountry };
use App\Http\Livewire\Dashboard\ShowDashboard;
use App\Http\Livewire\Dashboard\ShowLanding;
use App\Http\Livewire\Map\ShowMap;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::permanentRedirect('/', '/map')->name('front.index');
Route::get('/map', ShowMap::class)->name('front.map.index');
Route::get('/dashboard', ShowDashboard::class)->name('front.dashboard');

// Addresses
Route::get('/addresses', ListAddress::class)->name('front.address.index');
Route::get('/address/{uuid}', ShowAddress::class)->name('front.address.show');

// Categories
Route::get('/categories', ListCategory::class)->name('front.category.index');
Route::get('/category/{slug}', ShowCategory::class)->name('front.category.show');

// Countries & cities
Route::get('/countries', ListCountry::class)->name('front.country.index');
Route::get('/country/{cca3}', ShowCountry::class)->name('front.country.show');
Route::get('/country/{cca3}/{uuid}', ShowCity::class)->name('front.city.show');

Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function () {
    // Addresses
    Route::get('/address/create', CreateAddress::class)->name('admin.address.create');
    Route::post('/address/edit/{uuid}', EditAddress::class)->name('admin.address.edit');
    Route::post('/address/import', [AddressController::class, 'import'])->name('admin.address.import');
    Route::post('/address/export', [AddressController::class, 'export'])->name('admin.address.export');

    // Categories
    Route::get('/category/create', CreateCategory::class)->name('admin.category.create');
    Route::get('/category/edit/{slug}', EditCategory::class)->name('admin.category.edit');
    Route::post('/category/import', [CategoryController::class, 'import'])->name('admin.category.import');
    Route::post('/category/export', [CategoryController::class, 'export'])->name('admin.category.export');
});
