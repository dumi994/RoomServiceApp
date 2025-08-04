<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceMenuItemController;

Route::get('/', function () {
    return view('home');
});

/*
|--------------------------------------------------------------
| FRONTEND - servizi visibili agli utenti (per fare ordini)
|--------------------------------------------------------------
*/

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::resource('/orders', OrderController::class);
Route::get('/orders/{order}/status', [OrderController::class, 'getStatus'])->name('orders.status');
Route::post('/orders/{id}/update-status', [OrderController::class, 'update']);

/*
|--------------------------------------------------------------
| BACKEND - dashboard per gestione servizi e menu items
| Prefisso /dashboard
|--------------------------------------------------------------
*/

Route::prefix('dashboard')->name('dashboard.')->group(function () {

    // Dashboard home (esempio: lista ordini)
    Route::get('/', [OrderController::class, 'index'])->name('home');

    // Pagina menu dashboard
    Route::get('/menu', function () {
        return view('admin.menu.index');
    })->name('menu.index');

    // Gestione servizi
    Route::get('/services', [ServiceController::class, 'adminIndex'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Gestione menu items legati a servizi
    Route::get('/services/{service}/menu-items/create', [ServiceMenuItemController::class, 'create'])->name('services.menu-items.create');
    Route::post('/services/{service}/menu-items', [ServiceMenuItemController::class, 'store'])->name('services.menu-items.store');
});

require __DIR__ . '/auth.php';
