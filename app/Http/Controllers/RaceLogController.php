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
                    $raceLogs[$i]->incidents,
                    $raceLogs[$j]->incidents
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
        $raceLogs = RaceLog::with(['driver', 'race'])->orderBy('race_id')->orderBy('position')->get();
        return view('racelogs.index', compact('raceLogs'));
    }
}
