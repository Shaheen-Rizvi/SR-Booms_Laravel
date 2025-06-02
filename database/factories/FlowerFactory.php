<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Flower;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flower>
 */
class FlowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true), // "Red Rose Bouquet"
            'description' => $this->faker->sentence(20),
            'price' => $this->faker->randomFloat(2, 5, 100), // $5.00 - $100.00
            'color' => $this->faker->colorName,
            'stock_quantity' => $this->faker->numberBetween(0, 50),
            'image_url' => $this->faker->imageUrl(400, 400, 'flowers'),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}