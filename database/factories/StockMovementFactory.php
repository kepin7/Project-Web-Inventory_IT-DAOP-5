<?php

namespace Database\Factories;

use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockMovement>
 */
class StockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // spare_part_id akan dihandle di seeder
            'type' => fake()->randomElement(['in', 'out']),
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'reference' => fake()->optional()->bothify('REF-####??'),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
