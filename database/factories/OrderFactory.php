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
        return [
            'customer_id' => Customer::factory()->create(),
            'order_date' => fake()->date(),
            'order_time' => fake()->time(),
            'shipping_mode' => fake()->randomElement(['pickup', 'delivery']),
            'deliver_street' => fake()->streetAddress(),
            'deliver_city' => fake()->city(),
            'deliver_province' => fake()->state(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'preparing', 'completed', 'cancelled']),
            'note' => null,
        ];
    }
}
