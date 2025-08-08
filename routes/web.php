<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceMenuItemController;
use App\Models\Service;

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
Route::post('/services/{service}/upload-images', [ServiceController::class, 'uploadImages'])->name('services.upload.images');
Route::delete('/dashboard/services/{service}/delete-images', [ServiceController::class, 'deleteImage']);
Route::get('/dashboard/services/{service}/images', [ServiceController::class, 'imagesList']);

/* ADMIN */


Route::get('/dashboard', [OrderController::class, 'index']);

/* Route::get('/dashboard/menu', function () {

    return view('admin/menu/index');
}); */
/* Route::get('/dashboard/menu', [ServiceMenuItemController::class, 'index']); */
Route::resource('/dashboard/menu', ServiceMenuItemController::class);
/* Route::get('/dashboard/services', function () {

    return view('admin/service/index');
}); */
Route::get('/dashboard/services', [ServiceController::class, 'adminIndex'])->name('dashboard.services');



require __DIR__ . '/auth.php';
