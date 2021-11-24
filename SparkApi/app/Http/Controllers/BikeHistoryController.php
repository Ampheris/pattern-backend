<?php

/*
|--------------------------------------------------------------------------
| Bike history controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Bikelog;
use Illuminate\Http\Request;

/**
 *
 */
class BikeHistoryController extends Controller
{
    public function showOneBikesHistory($bikeId)
    {
        return response()->json(Bikelog::where('bike_id', $bikeId)->get());
    }

    public function showOneUsersBikeHistory($customerId)
    {
        return response()->json(Bikelog::where('customer_id', $customerId)->get());
    }
}
