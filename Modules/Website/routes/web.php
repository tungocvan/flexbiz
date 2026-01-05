<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\WebsiteController;
use Modules\Website\Livewire\Home;
use Modules\Website\Livewire\Product;

Route::middleware(['web'])->prefix('/website')->name('website.')->group(function(){
    Route::get('/', [WebsiteController::class,'index'])->name('index');
    Route::get('home', Home::class)->name('home');
    Route::get('product', Product::class)->name('product');
});
