<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Order::create([
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'room_number' => 101,
            'order_details' => '1 Spritz, 2 Panino Club',
            'status' => 'sent',
        ]);
    }
}
