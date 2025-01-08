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
        $tracks = ['Monza', 'Snetterton', 'Imola'];

        $randTrackIndex = array_rand($tracks);
        $track = $tracks[$randTrackIndex];

        Race::create([
            'track_name' => $track,
            'session_type' => 'R',
        ]);
    }
}
