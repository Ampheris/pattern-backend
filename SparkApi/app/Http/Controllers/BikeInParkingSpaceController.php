<?php

/*
|--------------------------------------------------------------------------
| Parkings controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\ParkingspaceBike;
use Illuminate\Http\Request;

/**
 *
 */
class BikeInParkingSpaceController extends Controller
{

    public function showAllBikesInParkingSpace($parkingspaceId)
    {
        return response()->json(ParkingspaceBike::where('parkingspace_id', $parkingspaceId)->get());
    }

    public function showBikeInParkingSpace($bikeId)
    {
        return response()->json(ParkingspaceBike::where('bike_id', $bikeId)->get());
    }

    public function add(Request $request)
    {
        /*
         * Requires:
         *  "parkingspace_id"
         *  "bike_id"
        */
        $parkingspaceBike = new ParkingspaceBike();
        try {
            $bike = $parkingspaceBike::create($request->all());
            return response()->json($bike, 201);
        } catch (\Exception $e) {
            return response('Bike already in placed in a parkingspace.', 500);
        }
    }

    public function remove($bikeId)
    {
        ParkingspaceBike::where('bike_id', $bikeId)->firstOrFail()->delete();
        return response('Bike removed', 200);
    }
}
