<?php
/*
|--------------------------------------------------------------------------
| Parkings controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Parkingspace_bike;
use Illuminate\Http\Request;

/**
 *
 */
class BikeInParkingSpaceController extends Controller
{

    function showAllBikesInParkingSpace($parkingspace_id)
    {
        return response()->json(Parkingspace_bike::where('parkingspace_id', $parkingspace_id)->get());
    }

    public function showBikeInParkingSpace($bike_id)
    {
        return response()->json(Parkingspace_bike::where('bike_id', $bike_id)->get());
    }

    public function add(Request $request)
    {
        /*
         * Requires:
         *  "parkingspace_id"
         *  "bike_id"
         *  "arrival"
        */
        $bike = Parkingspace_bike::create($request->all());

        return response()->json($bike, 201);
    }

    public function remove($bike_id)
    {
        Parkingspace_bike::where('bike_id', $bike_id)->firstOrFail()->delete();
        return response('Bike removed', 200);
    }
}
