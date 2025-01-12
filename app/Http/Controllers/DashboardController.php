<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Race;
use App\Models\RaceLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(): View
    {
        $steamId = 'S60531942045348651';
        $driver = Driver::where('steam_id', $steamId)->first();
        if (!$driver) {
            return view('dashboard.index', [
                'totalRaces' => 0,
                'trackData' => [],
            ])->withErrors('Driver not found.');
        }

        $totalRaces = RaceLog::where('driver_id', $driver->id)->count();
        $trackData = Race::join('race_logs', 'races.id', '=', 'race_logs.race_id')
            ->where('race_logs.driver_id', $driver->id)
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
