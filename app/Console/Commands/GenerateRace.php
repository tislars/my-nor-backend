<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Race;
use App\Models\RaceLog;
use App\Models\Driver;
use App\Services\EloService;

class GenerateRace extends Command
{
    protected $signature = 'generate:race';
    protected $description = 'Generate a race with randomized drivers and race logs';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return integer
     */
    public function handle(): int
    {
        $amountOfDrivers = rand(6, 12);
        $drivers = Driver::inRandomOrder()->take($amountOfDrivers)->get();

        if ($drivers->count() < 6) {
            $this->error('Not enough drivers in the database (minimum 6 required).');
            return 1;
        }

        $tracks = ['Monza', 'Snetterton', 'Imola'];
        $randTrackIndex = array_rand($tracks);
        $track = $tracks[$randTrackIndex];
        $race = Race::create([
            'track_name' => $track,
            'session_type' => 'R',
        ]);

        $this->info("Race created: {$race->track}");

        $positions = range(1, $drivers->count());
        shuffle($positions);

        foreach ($drivers as $index => $driver) {
            $milliseconds = rand(105000, 127000);
            $minutes = floor($milliseconds / 60000);
            $seconds = floor(($milliseconds % 60000) / 1000);
            $fractional = $milliseconds % 1000;
            $fastestLap = sprintf('%d:%02d.%03d', $minutes, $seconds, $fractional);
            $incidents = $this->generateIncidents();

            RaceLog::create([
                'race_id' => $race->id,
                'driver_id' => $driver->id,
                'position' => $positions[$index],
                'fastest_lap' => $fastestLap,
                'incidents' => $incidents,
            ]);
        }

        $this->info("Race logs created for {$drivers->count()} drivers.");

        $this->updateRankings($race);

        return 0;
    }

    /**
     * @param Race $race
     * @return void
     */
    private function updateRankings(Race $race): void
    {
        $eloService = new EloService();
        $raceLogs = $race->raceLogs()->orderBy('position')->get();

        for ($i = 0; $i < $raceLogs->count() - 1; $i++) {
            for ($j = $i + 1; $j < $raceLogs->count(); $j++) {
                $driverA = $raceLogs[$i]->driver;
                $driverB = $raceLogs[$j]->driver;

                $result = $eloService->calculateElo(
                    $driverA,
                    $driverB,
                    $raceLogs[$i]->position,
                    $raceLogs[$j]->position,
                    $raceLogs[$i]->incidents ?? 0,
                    $raceLogs[$j]->incidents ?? 0
                );

                $changeA = $result['changeA'];
                $changeB = $result['changeB'];

                $raceLogs[$i]->elo_change += $changeA;
                $raceLogs[$j]->elo_change += $changeB;
            }
        }

        foreach ($raceLogs as $log) {
            $log->save();
        }

        info("ELO rankings updated for race: {$race->track}");
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
