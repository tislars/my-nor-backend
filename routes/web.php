<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaceLogController;

Route::get('/', [RaceLogController::class, 'index']);
