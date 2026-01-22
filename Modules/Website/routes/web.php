<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\ProductController;
use Modules\Website\Http\Controllers\CartController;
use Modules\Website\Http\Controllers\CheckoutController;
use Modules\Website\Http\Controllers\AccountController;
use Modules\Website\Http\Controllers\AuthController;
use Modules\Website\Http\Controllers\WebsiteController;
use Modules\Website\Http\Controllers\PostController;

use Modules\Website\Http\Controllers\Admin\ProductController as AdminProductController;

$websitePrefix = config('website.route_prefix', 'website');

Route::middleware(['web','auth'])->prefix($websitePrefix)->group(function(){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES (CUSTOMER)
|--------------------------------------------------------------------------
*/
Route::middleware(['web'])->get('/', [WebsiteController::class, 'home'])->name('home');
Route::middleware(['web'])->get('/shop', [ProductController::class, 'index'])->name('product.list');

// Route::middleware(['web'])->get('/blog', [PostController::class, 'index'])->name('website.blog.index');
Route::middleware(['web'])->get('/blog', function (\Illuminate\Http\Request $request) {
    // Nếu có tham số ?category=abc trên URL thì truyền vào Livewire
    return view('Website::pages.blog.index', [
        'categorySlug' => $request->query('category')
    ]);
})->name('blog.index');
Route::middleware(['web'])->get('/blog/{slug}', [PostController::class, 'detail'])->name('blog.detail');

Route::middleware(['web'])->get('/login', [AuthController::class, 'login'])->name('login');
Route::middleware(['web'])->get('/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['web'])->group(function () {
    // 1. Trang chủ & Sản phẩm
   // Route::get('/', [ProductController::class, 'index'])->name('home');
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

// Route::prefix($websitePrefix.'/admin')
//     ->name($websitePrefix.'admin.')
//     ->middleware(['web','auth'])
//     ->group(function () {

//         Route::get('/', [AdminProductController::class, 'index'])->name('dashboard');

// });

// --- ACCOUNT ROUTES (Yêu cầu đăng nhập) ---
Route::middleware(['web','auth'])->prefix('account')->name('account.')->group(function () {
    // Dashboard
    Route::get('/', [AccountController::class, 'index'])->name('dashboard');

    // Các route sau này sẽ thêm: orders, profile...
    // Đơn hàng (Mới thêm)
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{code}', [AccountController::class, 'orderDetail'])->name('orders.detail');
    Route::get('/affiliate', [AccountController::class, 'affiliate'])->name('affiliate');
});

