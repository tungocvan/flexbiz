<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\AuthController;
use Modules\Admin\Http\Controllers\ProductController;
use Modules\Admin\Http\Controllers\MenuController;
use Modules\Admin\Http\Controllers\CategoryController;

Route::middleware(['web'])->group(function () {

    // Auth Routes (Placeholder)
    Route::get('login', [AuthController::class, 'login'])->name('login');

    // Protected Routes
    Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () { // Sau này thêm middleware admin sau
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        // === QUẢN LÝ MENU ===
        Route::prefix('menus')->name('menus.')->group(function() {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
        });

        Route::prefix('products')->name('products.')->group(function() {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        });

        Route::prefix('product-categories')->name('product-categories.')->group(function() {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        });

    });




});



