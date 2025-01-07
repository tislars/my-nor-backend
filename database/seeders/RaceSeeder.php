<?php

namespace Database\Seeders;

use App\Models\Race;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $index) {
            Race::create([
                'track_name' => 'Snetterton',
                'session_type' => now()->subDays($index),
            ]);
        }
    }
}
