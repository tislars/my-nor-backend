<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{

    public function index(): View
    {
        $drivers = Driver::orderByDesc('elo')->get();
        return view('leaderboard.index', compact('drivers'));
    }
}
