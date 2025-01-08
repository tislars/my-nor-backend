<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Race;
use App\Models\RaceLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaceLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $races = Race::all();

        foreach ($races as $race) {
            $drivers = Driver::inRandomOrder()->take(6)->get();

            $positions = range(1, $drivers->count());
            shuffle($positions);

            foreach ($drivers as $index => $driver) {
                $milliseconds = rand(105000, 127000);
                $minutes = floor($milliseconds / 60000);
                $seconds = floor(($milliseconds % 60000) / 1000);
                $fractional = $milliseconds % 1000;
                $time = sprintf('%d:%02d.%03d', $minutes, $seconds, $fractional);

                RaceLog::create([
                    'race_id' => $race->id,
                    'driver_id' => $driver->id,
                    'position' => $positions[$index],
                    'fastest_lap' => $time,
                    'incidents' => $this->generateIncidents(),
                ]);
            }
        }
    }

    private function generateIncidents(): int
    {
        $weights = [70, 20, 10, 7, 3];
        $values = [0, 1, 2, 3, 4];

        $sum = array_sum($weights);
        $rand = mt_rand(1, $sum);

        $cumulativeWeight = 0;
        foreach ($weights as $index => $weight) {
            $cumulativeWeight += $weight;
            if ($rand <= $cumulativeWeight) {
                return $values[$index];
            }
        }
    }
}
