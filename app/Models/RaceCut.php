<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaceCut extends Model
{
    use HasFactory;

    protected $fillable = [
        'race_car_id',
        'lap_number',
        'penalty_value',
        'cleared_in_lap',
    ];

    public function raceCar()
    {
        return $this->belongsTo(RaceCar::class);
    }
}
