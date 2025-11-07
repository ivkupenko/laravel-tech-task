<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    //Route::get('/products', [ProfileController::class, 'edit'])->name('products.edit');
    Route::patch('/products', [ProfileController::class, 'update'])->name('products.update');
    Route::delete('/products', [ProfileController::class, 'destroy'])->name('products.destroy');

    Route::get('/users', [UserController::class, 'index'])
        ->middleware('role')
        ->defaults('role', 'admin')
        ->name('users.index');
});

require __DIR__.'/auth.php';
