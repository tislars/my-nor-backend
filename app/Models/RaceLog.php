<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaceLog extends Model
{

    protected $fillable = ['race_id', 'driver_id', 'position', 'fastest_lap', 'incidents'];

    /** @use HasFactory<\Database\Factories\RaceLogFactory> */
    use HasFactory;

    /**
     * Get the driver associated with the race log.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get the race associated with the race log.
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
