<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chargingstation find($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chargingstation create($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chargingstation findOrFail($value)
*/
class Chargingstation extends Model
{
    use HasFactory;

    protected $fillable = [
        'x_pos',
        'y_pos',
        'radius',
        'name'
    ];
}
