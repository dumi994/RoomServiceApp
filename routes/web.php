<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceMenuItemController;
use App\Models\Service;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;

Route::get('/', function () {
    return view('home');
});

// Frontend
Route::resource('services', ServiceController::class);
Route::resource('orders', OrderController::class);
Route::get('orders/{order}/status', [OrderController::class, 'getStatus'])->name('orders.status');
Route::post('orders/{id}/update-status', [OrderController::class, 'update']);

// Admin
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('home');

    Route::resource('/menu', ServiceMenuItemController::class)->names('menu');
    Route::resource('/services', AdminServiceController::class)->names('services');

    Route::post('/services/{service}/upload-images', [AdminServiceController::class, 'uploadImages'])
        ->name('services.upload.images');
    Route::delete('/services/{service}/delete-images', [AdminServiceController::class, 'deleteImage'])
        ->name('services.delete.image');
    Route::get('/services/{service}/images', [AdminServiceController::class, 'imagesList'])
        ->name('services.images');
});

require __DIR__ . '/auth.php';
