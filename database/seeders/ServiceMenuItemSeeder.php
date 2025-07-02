<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceMenuItem;

class ServiceMenuItemSeeder extends Seeder
{
    public function run()
    {
        // Assumendo che Room Service abbia id 1
        ServiceMenuItem::create([
            'service_id' => 1,
            'name' => 'Cocktail Analcolico',
            'description' => 'Mix fresco di frutta tropicale servito con ghiaccio.',
            'price' => 6.00,
        ]);
        ServiceMenuItem::create([
            'service_id' => 1,
            'name' => 'Spritz',
            'description' => 'Classico aperitivo italiano con Aperol e prosecco.',
            'price' => 8.00,
        ]);
        // Continua per tutti gli altri menu item...
    }
}
