<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\ProductController;
use Modules\Website\Http\Controllers\CartController;
use Modules\Website\Http\Controllers\CheckoutController;
use Modules\Website\Http\Controllers\AccountController;
use Modules\Website\Http\Controllers\AuthController;
use Modules\Website\Http\Controllers\WebsiteController;

use Modules\Website\Http\Controllers\Admin\ProductController as AdminProductController;

$websitePrefix = config('website.route_prefix', 'website');

Route::middleware(['web','auth'])->prefix($websitePrefix)->name('website.')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES (CUSTOMER)
|--------------------------------------------------------------------------
*/
Route::middleware(['web'])->get('/', [WebsiteController::class, 'home'])->name('home');

Route::middleware(['web'])->prefix($websitePrefix)->name('website.')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');

    // 1. Trang chủ & Sản phẩm
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.detail');

    // 2. Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // 3. Thanh toán (Checkout)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/checkout/momo-callback', [CheckoutController::class, 'momoCallback'])->name('checkout.momo.callback');

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

});

// --- ACCOUNT ROUTES (Yêu cầu đăng nhập) ---
Route::middleware(['web','auth'])->prefix('account')->name('account.')->group(function () {
    // Dashboard
    Route::get('/', [AccountController::class, 'index'])->name('dashboard');

    // Các route sau này sẽ thêm: orders, profile...
    // Đơn hàng (Mới thêm)
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{code}', [AccountController::class, 'orderDetail'])->name('orders.detail');
});

