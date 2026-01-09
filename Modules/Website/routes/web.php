<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\WebsiteController;
use Modules\Website\Http\Controllers\ProductController;
use Modules\Website\Http\Controllers\CheckoutController;
use Modules\Website\Http\Controllers\CartController;
use Modules\Website\Livewire\Home;
// use Modules\Website\Livewire\Cart\CartPage;
// use Modules\Website\Livewire\Checkout\CheckoutPage;
// use Modules\Website\Livewire\Checkout\CheckoutSuccess;


Route::middleware(['web'])->prefix('/website')->name('website.')->group(function(){
    Route::get('/', [WebsiteController::class,'index'])->name('index');
    Route::get('home', Home::class)->name('home');

    Route::get('products', [ProductController::class, 'index'])
    ->name('products.index');

    Route::get('products/{slug}', [ProductController::class, 'show'])
        ->name('products.show');

    Route::get('/category/{slug}', [ProductController::class, 'index'])
        ->name('products.category');

    Route::get('cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::get('checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

    Route::get('checkout/success/{orderCode}', [CheckoutController::class, 'success'])
    ->name('checkout.success');


});


