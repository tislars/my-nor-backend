<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{

    protected $fillable = ['track_name', 'session_type'];

    /** @use HasFactory<\Database\Factories\RaceFactory> */
    use HasFactory;

    /**
     * Get all race logs for the race.
     */
    public function raceLogs()
    {
        return $this->hasMany(RaceLog::class);
    }
}
