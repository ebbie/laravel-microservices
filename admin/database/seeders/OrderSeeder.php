<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->count(30)->create()
        ->each(function (\App\Models\Order $order) {
            OrderItem::factory()->times(random_int(1, 5))->create([
                'order_id' => $order->id
            ]);
        });
    }
}
