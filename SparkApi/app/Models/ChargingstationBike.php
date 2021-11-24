<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChargingstationBike where($key, $value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChargingstationBike create($value)
*/
class ChargingstationBike extends Model
{
    use HasFactory;

    protected $fillable = [
        'chargingstation_id',
        'bike_id',
        'arrival',
        'departure'
    ];
}
