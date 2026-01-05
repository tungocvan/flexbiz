<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\WebsiteController;
use Modules\Website\Livewire\Home;
use Modules\Website\Livewire\Products\Index;
use Modules\Website\Livewire\Products\Show;

Route::middleware(['web'])->prefix('/website')->name('website.')->group(function(){
    Route::get('/', [WebsiteController::class,'index'])->name('index');
    Route::get('home', Home::class)->name('home');
    Route::get('products', Index::class)->name('products.index');
    Route::get('category/{slug}', Index::class)->name('products.category');
    Route::get('product/{slug}', Show::class)->name('products.show');
});
