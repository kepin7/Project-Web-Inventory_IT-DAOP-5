<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
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
            'name' => strtoupper(fake()->unique()->word()),
            'description' => fake()->sentence(),
            'icon' => fake()->randomElement(['Cpu', 'Monitor', 'Printer', 'HardDrive', 'Wifi', 'Battery', 'Mouse', 'Keyboard', 'Server']),
        ];
    }
}
