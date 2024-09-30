<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');

Route::middleware(['auth:admin', 'role:manager'])->group(function () {
    Route::resource('products', ProductController::class);
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.home');
    })->name('adminDashboard');

    Route::get('orders/monthly-chart', [OrderController::class, 'showOrdersByMonth'])->name('admin.orders.monthly_chart');
    Route::get('orders/export', [OrderController::class, 'exportCsv'])->name('admin.orders.export');
    Route::get('orders/export/excel', [OrderController::class, 'exportExcel'])->name('admin.orders.export.excel');

    Route::post('/orders/import', [OrderController::class, 'importExcel'])->name('orders.import');


    Route::resource('products', ProductController::class, ['as' => 'admin']);
    Route::resource('categories', CategoryController::class, ['as' => 'admin'])->except(['show']);;
    Route::resource('users', UserController::class, ['as' => 'admin']);
    Route::resource('orders', OrderController::class, ['as' => 'admin']);
    Route::resource('reviews', ReviewController::class, ['as' => 'admin']);

    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
});

