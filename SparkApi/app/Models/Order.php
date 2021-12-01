<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChargingstationBike where($value, $value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChargingstationBike create($value)
*/
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_price',
        'subscription',
        'bikehistory_id'
    ];
}
