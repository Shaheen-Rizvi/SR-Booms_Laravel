<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $categories = ['Roses', 'Tulips', 'Sunflowers', 'Orchids', 'Bouquets'];
        
        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'color' => $this->faker->hexColor,
        ];
    }
}