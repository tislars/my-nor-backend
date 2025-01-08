<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaceLogController;
use App\Http\Controllers\LeaderboardController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/racelogs', [RaceLogController::class, 'index'])->name('racelogs.index');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
