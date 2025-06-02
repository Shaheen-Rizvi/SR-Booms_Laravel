<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Flower;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::inRandomOrder()->first()->id,
        'flower_id' => Flower::inRandomOrder()->first()->id,
        'quantity' => $this->faker->numberBetween(1, 5),
        'unit_price' => $this->faker->randomFloat(2, 5, 50),
        ];
    }
}
