<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
        'total_amount' => $this->faker->randomFloat(2, 20, 500),
        'status' => $this->faker->randomElement(['pending', 'delivered', 'cancelled']),
        'delivery_date' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
    ];
}
}
