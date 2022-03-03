<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Livewire\Category\ListAddress;
use App\Http\Livewire\Category\ShowAddress;
use App\Http\Livewire\Category\ListCategory;
use App\Http\Livewire\Category\ShowCategory;
use App\Http\Livewire\Dashboard\ShowDashboard;
use App\Http\Livewire\Tag\ListTag;
use App\Http\Livewire\Tag\ShowTag;
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

Route::redirect('/', '/dashboard', 301);
Route::get('/dashboard', ShowDashboard::class)->name('dashboard');
//Route::get('/about', ShowAbout::class)->name('front.about');

// Addresses
Route::get('/addresses', ListAddress::class)->name('front.address.index');
Route::get('/address/{uuid}', ShowAddress::class)->name('front.address.show');

// Categories
Route::get('/categories', ListCategory::class)->name('front.category.index');
Route::get('/category/{uuid}', ShowCategory::class)->name('front.category.show');

// Tags
Route::get('/tags', ListTag::class)->name('front.tag.index');
Route::get('/tag/{uuid}', ShowTag::class)->name('front.tag.show');

Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function () {
    // Addresses
    Route::post('/address/store', [AddressController::class, 'store'])->name('admin.address.store');
    Route::post('/address/update', [AddressController::class, 'update'])->name('admin.address.update');
    Route::post('/address/import', [AddressController::class, 'import'])->name('admin.address.import');
    Route::post('/address/export', [AddressController::class, 'export'])->name('admin.address.export');

    // Categories
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.address.store');
    Route::post('/category/update', [CategoryController::class, 'update'])->name('admin.address.update');
    Route::post('/category/import', [CategoryController::class, 'import'])->name('admin.address.import');
    Route::post('/category/export', [CategoryController::class, 'export'])->name('admin.address.export');
});
