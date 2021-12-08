<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cityzone find($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cityzone create($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cityzone findOrFail($value)
*/
class Cityzone extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'X',
        'Y',
        'radius'
    ];
}
