<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parkingspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'X',
        'Y',
        'radius',
        'available',
        'name'
    ];
}
