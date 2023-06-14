<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
class OrderProductTableS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // get all orders
        $orders = Order::all();

        // get all products
        $products = Product::all();

        // for each order, attach random products
        foreach ($orders as $order) {
            $order->products()->attach(
                $products->random(rand(1, 3))->pluck('id')->toArray(),
            );
        }
    }
}
