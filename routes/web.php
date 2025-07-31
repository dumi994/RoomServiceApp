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
Route::post('/orders/{id}/update-status', [OrderController::class, 'update']);

/* ADMIN */


Route::get('/dashboard', [OrderController::class, 'index']);

require __DIR__ . '/auth.php';
