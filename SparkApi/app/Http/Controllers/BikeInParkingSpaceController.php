<?php

/*
|--------------------------------------------------------------------------
| Parkings controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\ParkingspaceBike;
use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class BikeInParkingSpaceController extends Controller
{

    public function showAllBikesInParkingSpace($parkingspaceId)
    {
        // $bike = new Bike();
        // $parkingspaceBike = new ParkingspaceBike();
        // $parkingspaceBike = $parkingspaceBike::where('parkingspace_id', $parkingspaceId)->get();

        $parkingspaceBikes = DB::table('bikes')
                    ->leftJoin('parkingspace_bikes', 'bikes.id', '=', 'parkingspace_bikes.bike_id')
                    ->select('bikes.*', 'parkingspace_bikes.*')
                    ->where('parkingspace_bikes.parkingspace_id', $parkingspaceId)
                    ->orderBy('created_at', 'desc')
                    ->get();
        return response()->json($parkingspaceBikes);

        // return response()->json(ParkingspaceBike::where('parkingspace_id', $parkingspaceId)->get());
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
