<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Entities\User;

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
        $userId = $this->faker->boolean(20) ? User::inRandomOrder()->value('id') : null;
        $default = $userId ? 0 : 1;

        return [
            'info' => json_encode(["en" => ["name" => $this->faker->word()]]),
            'type' => $this->faker->randomElement(['revenue', 'expense']),
            'icon' => $this->faker->word(),
            'color' => $this->faker->safeColorName(),
            'default' => $default,
            'parent_id' => Category::inRandomOrder()->value('id'),
            'user_id' => $userId,
        ];
    }
}