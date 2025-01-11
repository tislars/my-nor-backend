<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\RaceLog;
use App\Services\EloService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RaceLogController extends Controller
{

    public function store(Request $request)
    {
        // Assuming that the race is already created and we just store race logs
        $race = Race::findOrFail($request->race_id);

        // Store race logs for all drivers
        foreach ($request->race_logs as $raceLogData) {
            $raceLog = new RaceLog($raceLogData);
            $race->raceLogs()->save($raceLog);
        }

        // After storing the race logs, update the ELO rankings
        $this->updateRankings($race);

        return redirect()->route('racelogs.index');
    }

    private function updateRankings(Race $race)
    {
        $eloService = new EloService();
        $raceLogs = $race->raceLogs()->orderBy('position')->get();

        for ($i = 0; $i < count($raceLogs) - 1; $i++) {
            for ($j = $i + 1; $j < count($raceLogs); $j++) {
                $driverA = $raceLogs[$i]->driver;
                $driverB = $raceLogs[$j]->driver;

                [$changeA, $changeB] = $eloService->calculateElo(
                    $driverA,
                    $driverB,
                    $raceLogs[$i]->position,
                    $raceLogs[$j]->position,
                );

                $raceLogs[$i]->elo_change += $changeA;
                $raceLogs[$j]->elo_change += $changeB;
            }
        }

        foreach ($raceLogs as $log) {
            $log->save();
        }
    }

    public function index(): View
    {
        $headers = [
            'ID',
            'Track',
            'Session Type',
            'Driver',
            'Position',
            'Fatest Lap',
            'Incidents',
            'ELO Change',
            'ELO'
        ];
        $raceLogs = RaceLog::with(['driver', 'race'])
            ->orderBy('race_id')
            ->orderBy('position')
            ->paginate(10);

        $rows = $raceLogs->map(function ($log) {
            $eloChange = $log->elo_change;

            return [
                'Race ID' => '#' . $log->race->id,
                'Track' => $log->race->track_name,
                'Session Type' => $log->race->session_type,
                'Driver' => $log->driver->first_name . ' ' . $log->driver->last_name,
                'Position' => $log->position,
                'Fastest Lap' => $log->fastest_lap,
                'Incidents' => $log->incidents,
                'ELO Change' => [
                    'value' => $eloChange,
                    'class' => $eloChange > 0
                        ? 'bg-green-500 text-white'
                        : ($eloChange < 0 ? 'bg-red-500 text-white' : 'bg-gray-500 text-white'),
                ],
                'ELO' => number_format($log->driver->elo, 0),
            ];
        })
            ->toArray();

        return view('racelogs.index', compact('raceLogs', 'headers', 'rows'));
    }
}
