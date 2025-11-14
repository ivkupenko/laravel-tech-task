<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\Products\AdminAttributeController;
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
});

Route::prefix('client')->middleware(['auth', 'role:client'])->name('client.')->group(function () {
    Route::resource('products', ClientProductController::class)->only(['index', 'show']);

    Route::get('/cart', [ClientCartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [ClientCartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [ClientCartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{item}', [ClientCartController::class, 'update'])->name('cart.update');
});

require __DIR__ . '/auth.php';
