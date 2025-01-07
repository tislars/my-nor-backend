<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RaceLog>
 */
class RaceLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seconds = rand(105, 126);
        $time = gmdate('i:s', $seconds);

        return [
            'race_id' => \App\Models\Race::factory(),
            'driver_id' => \App\Models\Driver::factory(),
            'position' => $this->faker->numberBetween(1, 16),
            'fastest_lap' => $time,
            'incidents' => $this->faker->numberBetween(0, 5),
        ];
    }
}
