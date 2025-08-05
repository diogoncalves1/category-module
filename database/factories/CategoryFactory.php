<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'info' => '{"en": {name: "' . $this->faker->word() . '"}}',
            'type' => $this->faker->randomElement(['revenue', 'expense']),
            'icon' => $this->faker->word(),
            'color' => $this->faker->colorName(),
            'default' => $this->faker->boolean(20),
            'parent_id' => Category::pluck('id')->random(),
            // 'user_id' => 
        ];
    }
}