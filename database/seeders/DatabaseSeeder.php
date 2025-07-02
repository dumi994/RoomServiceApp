<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use Database\Seeders\ServiceSeeder;
use Database\Seeders\ServiceMenuItemSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OrderItemSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            ServiceMenuItemSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
    }
}
