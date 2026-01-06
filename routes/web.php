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

Route::controller(ProfileController::class)->name('profile.')->group(function () {
    Route::get('/profile', 'edit')->name('edit');
    Route::patch('/profile', 'update')->name('update');
    Route::delete('/profile', 'destroy')->name('destroy');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::resource('products', AdminProductController::class);
    Route::resource('attributes', AdminAttributeController::class)->except(['show'])->names('products.attributes');

    Route::controller(AdminProductVariantController::class)->group(function () {
        Route::prefix('products/{product}')->name('products.variants.')->group(function () {
            Route::get('variants', 'index')->name('index');
            Route::get('variants/create', 'create')->name('create');
            Route::post('variants', 'store')->name('store');
            Route::delete('variants/{variant}', 'destroy')->name('destroy');
        });
    });

    Route::resource('carts', AdminCartController::class)->only(['index', 'show']);
    
    Route::controller(AdminCartController::class)->group(function () {
        Route::prefix('/carts/{cart}')->name('carts.')->group(function () {
            Route::get('/edit/{item}', 'editItem')->name('editItem');
            Route::patch('/update/{item}', 'updateItem')->name('updateItem');
            Route::delete('/remove/{item}', 'removeItem')->name('removeItem');
        });
    });
});

Route::prefix('client')->middleware(['auth', 'role:client'])->name('client.')->group(function () {
    Route::resource('products', ClientProductController::class)->only(['index', 'show']);
    
    Route::controller(ClientCartController::class)->group(function () {
        Route::prefix('/cart')->name('cart.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('/add/{product}', 'add')->name('add');
            Route::delete('/remove/{item}', 'remove')->name('remove');
            Route::patch('/update/{item}', 'update')->name('update');
        });
        Route::get('/products/{product}/select-attributes', 'selectAttributes')->name('cart.attributes');
        Route::post('/products/{product}/add-with-attributes', 'addWithAttributes')->name('cart.addWithAttributes');
    });
});

require __DIR__ . '/auth.php';
