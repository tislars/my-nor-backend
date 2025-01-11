<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaceCar extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'race_id',
        'car_id',
        'race_number',
        'car_model',
        'car_group',
        'team_name',
        'driver_id',
    ];

    /**
     * Get the race associated with the car.
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Get the driver associated with the car.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
