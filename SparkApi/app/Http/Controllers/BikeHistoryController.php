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
    public function showOneBikesHistory($id)
    {
        return response()->json(Bikelog::where('bike_id', $id));
    }

    public function showOneUsersBikeHistory($id)
    {
        return response()->json(Bikelog::find('customer_id', $id));
    }
}
