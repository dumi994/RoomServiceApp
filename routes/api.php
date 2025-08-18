<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\OrderController;

Route::get('/services', [ServiceController::class, 'index']);
Route::put('services/{service}', [ServiceController::class, 'update']);

Route::get('/orders', [OrderController::class, 'index']);
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
