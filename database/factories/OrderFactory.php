<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 10, 500);
        $points = floor($amount / 5);

        return [
            'customer_id' => Customer::factory(),
            'amount' => $amount,
            'points_earned' => $points,
        ];
    }
}
