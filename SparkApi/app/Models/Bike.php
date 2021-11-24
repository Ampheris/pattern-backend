<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bike find($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bike create($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bike findOrFail($value)
*/
class Bike extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'battery',
        'velocity',
        'X',
        'Y'
    ];
}
