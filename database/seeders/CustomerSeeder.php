<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory(10)->create()->each(function ($customer) {
            $orders = Order::factory(rand(1, 5))->create([
                'customer_id' => $customer->id,
            ]);

            $totalPoints = $orders->sum('points_earned');
            $customer->update(['points' => $totalPoints]);
        });
    }
}
