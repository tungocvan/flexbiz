<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\AuthController;
use Modules\Admin\Http\Controllers\ProductController;
use Modules\Admin\Http\Controllers\MenuController;

Route::middleware(['web'])->group(function () {

    // Auth Routes (Placeholder)
    Route::get('login', [AuthController::class, 'login'])->name('login');

    // Protected Routes
    Route::middleware([])->prefix('admin')->name('admin.')->group(function () { // Sau này thêm middleware admin sau
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
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
    });



});



