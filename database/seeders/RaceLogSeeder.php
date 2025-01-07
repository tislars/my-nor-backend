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
        $drivers = Driver::all();
        $races = Race::all();

        foreach ($races as $race) {
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
                    'incidents' => rand(0, 5),
                ]);
            }
        }
    }
}
