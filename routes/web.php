<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;



Route::get('/', function () {

    return view('home');
});

/* Route::get('/services', function () {
    $services = [
        [
            'id' => 1,
            'name' => 'Room Service',
            'icon' => 'images/svg/restaurant-svgrepo-com.svg',
            'description' => 'Servizio in camera disponibile 24 ore su 24.',
            'available' => true,

            'menu' => [
                [
                    'name' => 'Cocktail Analcolico',
                    'description' => 'Mix fresco di frutta tropicale servito con ghiaccio.',
                    'price' => 6.00,

                ],
                [
                    'name' => 'Spritz',
                    'description' => 'Classico aperitivo italiano con Aperol e prosecco.',
                    'price' => 8.00,

                ],
                [
                    'name' => 'Panino Club',
                    'description' => 'Pane tostato con pollo grigliato, lattuga, pomodoro e maionese.',
                    'price' => 10.00,

                ],
                [
                    'name' => 'Insalata Estiva',
                    'description' => 'Insalata leggera con feta, olive, cetrioli e pomodorini.',
                    'price' => 9.00,

                ],
                [
                    'name' => 'Gelato Artigianale',
                    'description' => 'Coppetta con 2 gusti a scelta.',
                    'price' => 5.00,

                ],
            ]
        ],
        [
            'id' => 2,
            'name' => 'Pool',
            'icon' => 'images/svg/swimming-pool-svgrepo-com.svg',
            'description' => 'Accesso alla piscina all\'aperto con area relax.',
            'available' => true,

            'menu' => [
                [
                    'name' => 'Cocktail Analcolico',
                    'description' => 'Mix fresco di frutta tropicale servito con ghiaccio.',
                    'price' => 6.00,

                ],
                [
                    'name' => 'Spritz',
                    'description' => 'Classico aperitivo italiano con Aperol e prosecco.',
                    'price' => 8.00,

                ],
                [
                    'name' => 'Panino Club',
                    'description' => 'Pane tostato con pollo grigliato, lattuga, pomodoro e maionese.',
                    'price' => 10.00,

                ],
                [
                    'name' => 'Insalata Estiva',
                    'description' => 'Insalata leggera con feta, olive, cetrioli e pomodorini.',
                    'price' => 9.00,

                ],
                [
                    'name' => 'Gelato Artigianale',
                    'description' => 'Coppetta con 2 gusti a scelta.',
                    'price' => 5.00,

                ],
            ]
        ],
        [
            'id' => 3,
            'name' => 'Laundry Service',
            'icon' => 'images/svg/laundry-machine-svgrepo-com.svg',
            'description' => 'Servizio lavanderia con ritiro e consegna in camera.',
            'available' => true,

            // Qui puoi anche omettere il menu se non c'è nulla da ordinare
        ],
    ];

    return view('services.index', compact('services'));
}); */
Route::get('/services', [ServiceController::class, 'index']);
require __DIR__ . '/auth.php';
