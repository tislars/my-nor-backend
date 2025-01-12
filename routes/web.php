<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaceLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\RaceCarController;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/steam', function () {
    return Socialite::driver('steam')->redirect();
})->name('auth.steam');

Route::get('/auth/steam/callback', function () {
    $steamUser = Socialite::driver('steam')->user();
    session([
        'steam_id' => $steamUser->id,
        'name' => $steamUser->nickname,
        'avatar' => $steamUser->avatar,
    ]);

    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/racelogs', [RaceLogController::class, 'index'])->name('racelogs.index');
Route::get('/race-cars', [RaceCarController::class, 'index'])->name('race-cars.index');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboards.index');
Route::get('/leaderboard/fastest-laps/{track}', [LeaderboardController::class, 'fastestLaps'])
    ->name('leaderboards.fastest-laps')
    ->where('track', '[a-z\-]+');
Route::get('/leaderboard/most-cuts/{track}', [LeaderboardController::class, 'mostCuts'])->name('leaderboards.most-cuts');

Route::get('/api/leaderboard/fastest-laps/{track}', [LeaderboardController::class, 'fastestLapsResponse'])->name('api.leaderboards.fastest-laps');
