<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\ProductController;
use Modules\Website\Http\Controllers\CartController;
use Modules\Website\Http\Controllers\CheckoutController;

use Modules\Website\Http\Controllers\Admin\ProductController as AdminProductController;

$websitePrefix = config('website.route_prefix', 'website');

Route::middleware(['web','auth'])->prefix($websitePrefix)->name('website.')->group(function(){
    Route::get('/admin', [WebsiteController::class,'adminPage'])->name('index');
});

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES (CUSTOMER)
|--------------------------------------------------------------------------
*/

Route::middleware(['web'])->prefix($websitePrefix)->name('website.')->group(function () {
    // 1. Trang chủ & Sản phẩm
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.detail');

    // 2. Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // 3. Thanh toán (Checkout)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

/*
|--------------------------------------------------------------------------
| BACKEND ROUTES (ADMIN)
|--------------------------------------------------------------------------
*/

Route::prefix($websitePrefix.'/admin')
    ->name($websitePrefix.'admin.')
    ->middleware(['web','auth'])
    ->group(function () {

        Route::get('/', [AdminProductController::class, 'index'])->name('dashboard');

        // Route::prefix('categories')
        //     ->name('categories.')
        //     ->group(function () {

        //         Route::get('/', [AdminCategoryController::class, 'index'])->name('index');
        //         Route::get('/create', [AdminCategoryController::class, 'create'])->name('create');
        //         Route::post('/', [AdminCategoryController::class, 'store'])->name('store');
        //         Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('edit');
        //         Route::put('/{category}', [AdminCategoryController::class, 'update'])->name('update');
        //         Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('destroy');
        //     });

        // Route::prefix('products')
        //     ->name('products.')
        //     ->group(function () {

        //         Route::get('/', [AdminProductController::class, 'index'])->name('index');
        //         Route::get('/create', [AdminProductController::class, 'create'])->name('create');
        //         Route::post('/', [AdminProductController::class, 'store'])->name('store');
        //         Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
        //         Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
        //         Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
        //     });

        // Route::prefix('orders')
        //     ->name('orders.')
        //     ->group(function () {

        //         Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        //         Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        // });
});
