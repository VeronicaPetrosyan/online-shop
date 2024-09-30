<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');
Route::resource('product', ProductController::class);
Route::post('product/{product}/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/category/{category}', [CategoryController::class, 'showProducts'])->name('category.products');

Route::get('/cart/get-data', [CartController::class, 'getCartData']);
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/{cartItemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::resource('cart', CartController::class);

Route::resource('checkout', CheckoutController::class);
Route::resource('order', OrderController::class);
