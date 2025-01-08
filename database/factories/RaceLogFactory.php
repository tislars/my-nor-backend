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
        $milliseconds = rand(105000, 127000);
        $minutes = floor($milliseconds / 60000);
        $seconds = floor(($milliseconds % 60000) / 1000);
        $fractional = $milliseconds % 1000;
        $time = sprintf('%d:%02d.%03d', $minutes, $seconds, $fractional);

        return [
            'race_id' => \App\Models\Race::factory(),
            'driver_id' => \App\Models\Driver::factory(),
            'position' => $this->faker->numberBetween(1, 16),
            'fastest_lap' => $time,
            'incidents' => $this->faker->numberBetween(0, 5),
        ];
    }
}
