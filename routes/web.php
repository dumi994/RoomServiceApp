<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceMenuItemController;



Route::get('/', function () {

    return view('home');
});

/* Route::get('/services', [ServiceController::class, 'index']); */
Route::resource('/services', ServiceController::class);
Route::resource('/orders', OrderController::class);
Route::get('/orders/{order}/status', [OrderController::class, 'getStatus'])->name('orders.status');
Route::post('/orders/{id}/update-status', [OrderController::class, 'update']);

/* DA RIVEDERE QUI */
Route::get('/services/{service}/menu-items/create', [ServiceMenuItemController::class, 'create'])->name('services.menu-items.create');
Route::post('/services/{service}/menu-items', [ServiceMenuItemController::class, 'store'])->name('services.menu-items.store');

/* ADMIN */


Route::get('/dashboard', [OrderController::class, 'index']);

Route::get('/dashboard/menu', function () {

    return view('admin/menu/index');
});

require __DIR__ . '/auth.php';
