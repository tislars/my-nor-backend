<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'short_name' => strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 2)),
            'player_id' => 'S' . str_pad((string)mt_rand(0, pow(10, 8) - 1), 8, '0', STR_PAD_LEFT) . str_pad((string)mt_rand(0, pow(10, 8) - 1), 9, '0', STR_PAD_LEFT),
            'elo' => 1000,
        ];
    }
}
