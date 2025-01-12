<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\RaceLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(): View
    {
        $userId = 3;
        $totalRaces = RaceLog::where('driver_id', $userId)->count();

        $trackData = Race::join('race_logs', 'races.id', '=', 'race_logs.race_id')
        ->where('race_logs.driver_id', $userId)
            ->select('races.track_name', \DB::raw('MIN(race_logs.fastest_lap) as fastest_lap'))
            ->groupBy('races.track_name')
            ->orderBy('races.track_name')
            ->get()
            ->map(function ($race) {
                return [
                    'track' => $race->track_name,
                    'fastest_lap' => $race->fastest_lap,
                ];
            })
            ->toArray();

        return view('dashboard.index', compact('totalRaces', 'trackData'));
    }
}
