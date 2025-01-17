<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\RaceCar;
use App\Models\RaceLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeaderboardController extends Controller
{

    public function index(): View
    {
        $drivers = Driver::orderByDesc('elo')->paginate(10);
        $currentPage = $drivers->currentPage();
        $perPage = $drivers->perPage();
        $headers = ['Rank', 'Short Name', 'Name', 'Steam ID', 'ELO', 'Safety Rating'];
        $rows = $drivers->map(function ($driver, $index) use ($currentPage, $perPage) {
            return [
                'rank' => '#' . (($currentPage - 1) * $perPage + $index + 1),
                'short_name' => $driver->short_name,
                'name' => $driver->first_name . ' ' . $driver->last_name,
                'steam_id' => $driver->steam_id,
                'elo' => number_format($driver->elo, 0),
                'safety_rating' => '...',
            ];
        })->toArray();

        return view('leaderboards.index', compact('headers', 'rows', 'drivers'));
    }

    /**
     * @param string $track
     * @return View
     */
    public function fastestLaps(string $track): View
    {
        $trackFormatted = ucwords(str_replace('-', ' ', $track));

        $leaderboard = RaceLog::whereHas('race', function ($query) use ($track) {
            $query->where('track_name', $track);
        })
            ->with('driver')
            ->orderBy('fastest_lap', 'asc')
            ->take(10)
            ->get()
            ->map(function ($log, $index) {
                return [
                    'position' => $index + 1,
                    'driver' => $log->driver->first_name . ' ' . $log->driver->last_name,
                    'fastest_lap' => $log->fastest_lap,
                ];
            })
            ->toArray();

        return view('leaderboards.fastest_laps', [
            'leaderboard' => $leaderboard,
            'track' => $trackFormatted,
        ]);
    }

    /**
     * @param string $track
     * @return View
     */
    public function fastestLapsResponse(string $track)
    {
        $leaderboard = RaceLog::whereHas('race', function ($query) use ($track) {
            $query->where('track_name', $track);
        })
            ->with('driver')
            ->orderBy('fastest_lap', 'asc')
            ->take(10)
            ->get()
            ->map(function ($log, $index) {
                return [
                    'position' => $index + 1,
                    'driver' => $log->driver->first_name . ' ' . $log->driver->last_name,
                    'fastest_lap' => $log->fastest_lap,
                ];
            });

            return response()->json([
                'leaderboard' => $leaderboard,
                'track' => $track,
            ]);
    }

    /**
     * @param string $track
     * @return View
     */
    public function mostCuts(string $track): View
    {
        $trackFormatted = ucwords(str_replace('-', ' ', $track));

        $mostCuts = RaceCar::whereHas('race', function ($query) use ($track) {
            $query->where('track_name', $track);
        })
            ->join('race_cuts', 'race_cars.id', '=', 'race_cuts.race_car_id')
            ->join('drivers', 'race_cars.driver_id', '=', 'drivers.id')
            ->select('drivers.first_name', 'drivers.last_name', \DB::raw('COUNT(race_cuts.id) as total_cuts'))
            ->groupBy('drivers.id', 'drivers.first_name', 'drivers.last_name')
            ->orderByDesc('total_cuts')
            ->take(10)
            ->get()
            ->map(function ($log, $index) {
                return [
                    'position' => $index + 1,
                    'driver' => $log->first_name . ' ' . $log->last_name,
                    'total_cuts' => $log->total_cuts,
                ];
            })
            ->toArray();

        return view('leaderboards.most_cuts', [
            'track' => $trackFormatted,
            'leaderboard' => $mostCuts,
        ]);
    }
}
