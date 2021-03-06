<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = ['phone','TV','computer'];
        return [
            'name' => fake()->name(),
            'price' => fake()->randomFloat(null,1,10000),
            'VAT' => fake()->randomFloat(null , 1, 25),
            'category' => $category[array_rand($category)],
            'description' => fake()->paragraph(3),
        ];
    }
}
