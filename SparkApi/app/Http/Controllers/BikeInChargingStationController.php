<?php
/*
|--------------------------------------------------------------------------
| Parkings controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Chargingstation_bike;
use Illuminate\Http\Request;

/**
 *
 */
class BikeInChargingStationController extends Controller
{

    function showAllBikesInChargingstation($chargingstation_id)
    {
        return response()->json(Chargingstation_bike::where('chargingstation_id', $chargingstation_id)->get());
    }

    public function showBikeInChargingStation($bike_id)
    {
        return response()->json(Chargingstation_bike::where('bike_id', $bike_id)->get());
    }

    public function add(Request $request)
    {
        /*
         * Requires:
         *  "chargingstation_id"
         *  "bike_id"
         *  "arrival"
        */
        $bike = Chargingstation_bike::create($request->all());

        return response()->json($bike, 201);
    }

    public function remove($bike_id)
    {
        Chargingstation_bike::where('bike_id', $bike_id)->firstOrFail()->delete();
        return response('Bike removed', 200);
    }
}
