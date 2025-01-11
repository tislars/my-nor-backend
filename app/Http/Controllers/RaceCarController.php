<?php

namespace App\Http\Controllers;

use App\Models\RaceCar;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RaceCarController extends Controller
{
    public function index(): View
    {
        $raceCars = RaceCar::with('driver', 'race')->paginate(10);
        $headers = ['ID', 'Race ID', 'Car ID', 'Race Number', 'Car Model', 'Driver', 'Team Name', 'Actions'];
        $rows = $raceCars->map(function ($raceCar) {
            return [
                $raceCar->id,
                $raceCar->race_id,
                $raceCar->car_id,
                $raceCar->race_number,
                $raceCar->car_model,
                $raceCar->driver->first_name . ' ' . $raceCar->driver->last_name ?? 'N/A',
                $raceCar->team_name,
                '<a href="#" class="btn btn-primary btn-sm">View</a>',
            ];
        })
        ->toArray();

        return view('race-cars.index', compact('headers', 'rows', 'raceCars'));
    }
}
