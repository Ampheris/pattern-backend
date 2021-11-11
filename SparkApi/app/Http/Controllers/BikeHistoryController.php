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
    public function showOneBikesHistory($bike_id)
    {
        return response()->json(Bikelog::where('bike_id', $bike_id)->get());
    }

    public function showOneUsersBikeHistory($customer_id)
    {
        return response()->json(Bikelog::where('customer_id', $customer_id)->get());
    }
}
