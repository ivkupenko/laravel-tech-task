<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\Products\AdminAttributeController;
use App\Http\Controllers\Admin\Products\AdminProductVariantController;
use App\Http\Controllers\Admin\AdminCartController;
use App\Http\Controllers\Client\ClientCartController;
use App\Http\Controllers\Client\ClientProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::resource('products', AdminProductController::class);
    Route::resource('attributes', AdminAttributeController::class)->except(['show'])->names('products.attributes');

    Route::prefix('products/{product}')->name('products.variants.')->group(function () {
        Route::get('variants', [AdminProductVariantController::class, 'index'])->name('index');
        Route::get('variants/create', [AdminProductVariantController::class, 'create'])->name('create');
        Route::post('variants', [AdminProductVariantController::class, 'store'])->name('store');
        Route::delete('variants/{variant}', [AdminProductVariantController::class, 'destroy'])->name('destroy');
    });

    Route::resource('carts', AdminCartController::class)->only(['index', 'show']);
    Route::prefix('/carts/{cart}')->name('carts.')->group(function () {
        Route::get('/edit/{item}', [AdminCartController::class, 'editItem'])->name('editItem');
        Route::patch('/update/{item}', [AdminCartController::class, 'updateItem'])->name('updateItem');
        Route::delete('/remove/{item}', [AdminCartController::class, 'removeItem'])->name('removeItem');
    });
});

Route::prefix('client')->middleware(['auth', 'role:client'])->name('client.')->group(function () {
    Route::resource('products', ClientProductController::class)->only(['index', 'show']);

    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('', [ClientCartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [ClientCartController::class, 'add'])->name('add');
        Route::delete('/remove/{item}', [ClientCartController::class, 'remove'])->name('remove');
        Route::patch('/update/{item}', [ClientCartController::class, 'update'])->name('update');
    });

    
    Route::get('/products/{product}/select-attributes', [ClientCartController::class, 'selectAttributes'])->name('cart.attributes');
    Route::post('/products/{product}/add-with-attributes', [ClientCartController::class, 'addWithAttributes'])->name('cart.addWithAttributes');
});

require __DIR__ . '/auth.php';
