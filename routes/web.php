<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaceLogController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\RaceCarController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/racelogs', [RaceLogController::class, 'index'])->name('racelogs.index');
Route::get('/race-cars', [RaceCarController::class, 'index'])->name('race-cars.index');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboards.index');
Route::get('/leaderboard/fastest-laps/{track}', [LeaderboardController::class, 'fastestLaps'])
    ->name('leaderboards.fastest-laps')
    ->where('track', '[a-z\-]+');
Route::get('/leaderboard/most-cuts/{track}', [LeaderboardController::class, 'mostCuts'])->name('leaderboards.most-cuts');
