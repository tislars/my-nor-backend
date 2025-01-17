<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['first_name', 'last_name', 'short_name', 'steam_id', 'elo'];

    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory;

    /**
     * Get all race logs associated with the driver.
     */
    public function raceLogs()
    {
        return $this->hasMany(RaceLog::class);
    }

    /**
     * Get all race cars associated with the driver.
     */
    public function raceCars()
    {
        return $this->hasMany(RaceCar::class);
    }
}
