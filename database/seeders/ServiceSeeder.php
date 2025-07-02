<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::create([
            'name' => 'Room Service',
            'icon' => 'images/svg/restaurant-svgrepo-com.svg',
            'description' => 'Servizio in camera disponibile 24 ore su 24.',
            'available' => true,
        ]);

        Service::create([
            'name' => 'Pool',
            'icon' => 'images/svg/swimming-pool-svgrepo-com.svg',
            'description' => "Accesso alla piscina all'aperto con area relax.",
            'available' => true,
        ]);

        Service::create([
            'name' => 'Laundry Service',
            'icon' => 'images/svg/laundry-machine-svgrepo-com.svg',
            'description' => 'Servizio lavanderia con ritiro e consegna in camera.',
            'available' => true,
        ]);
    }
}
