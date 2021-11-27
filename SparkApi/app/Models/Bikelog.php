<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChargingstationBike where($key, $value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChargingstationBike create($value)
*/
class Bikelog extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_x',
        'start_y',
        'start_time',
        'stop_x',
        'stop_y',
        'stop_time',
        'customer_id',
        'bike_id'
    ];
}
