<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
