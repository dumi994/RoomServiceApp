<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Order;
use App\Models\ServiceMenuItem;
use App\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        $order = Order::first();
        $menuItem = ServiceMenuItem::first();

        if ($order && $menuItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'service_menu_item_id' => $menuItem->id,
                'quantity' => 2,
                'price' => 10.00,
            ]);
        } else {
            // Gestisci il caso in cui mancano dati, es. logga o fai fallback
            echo "Ordine o menu item non trovato, seed saltato\n";
        }
    }
}
