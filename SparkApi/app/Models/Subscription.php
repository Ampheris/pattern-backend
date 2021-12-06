<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription where($key, $value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription findOrFail($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription find($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription create($value)
*/
class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'renewal_date',
        'customer_id',
        'cancelation_date',
        'price'
    ];
}
