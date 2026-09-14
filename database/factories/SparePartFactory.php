<?php

namespace Database\Factories;

use App\Models\SparePart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SparePart>
 */
class SparePartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => fake()->randomElement(['HP', 'DELL', 'LENOVO', 'ASUS', 'ACER', 'SPC', 'RAKITAN']),
            'type' => fake()->bothify('Model-####??'),
            'serial_number' => fake()->unique()->bothify('SN-########'),
            'inventory_number' => fake()->unique()->bothify('IT.###.####.#.####.#####'),
            'description' => fake()->sentence(),
            'condition' => fake()->randomElement(['Normal', 'Perbaikan', 'Rusak']),
            // category_id and location_id akan dihandle di seeder
        ];
    }
}
