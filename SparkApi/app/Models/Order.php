<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bikelog;

/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order where($key, $value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order create($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order find($value)
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
