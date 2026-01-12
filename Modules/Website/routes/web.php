<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\ProductController;
use Modules\Website\Http\Controllers\CartController;
use Modules\Website\Http\Controllers\CheckoutController;

Route::middleware(['web','auth'])->prefix('/website')->name('website.')->group(function(){
    Route::get('/admin', [WebsiteController::class,'adminPage'])->name('index');
});


Route::middleware(['web'])->prefix('/website')->name('website.')->group(function () {
    // 1. Trang chủ & Sản phẩm
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.detail');

    // 2. Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // 3. Thanh toán (Checkout)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});
