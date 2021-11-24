<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parkingspace find($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parkingspace create($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parkingspace findOrFail($value)
*/
class Parkingspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'x_pos',
        'y_pos',
        'radius',
        'name'
    ];
}
