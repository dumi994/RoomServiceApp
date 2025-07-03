<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;



Route::get('/', function () {

    return view('home');
});

/* Route::get('/services', [ServiceController::class, 'index']); */
Route::resource('/services', ServiceController::class);
Route::resource('/orders', OrderController::class);
Route::get('/orders/{order}/status', [OrderController::class, 'getStatus'])->name('orders.status');
require __DIR__ . '/auth.php';
