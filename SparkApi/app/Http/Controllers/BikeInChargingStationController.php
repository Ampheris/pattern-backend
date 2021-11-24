<?php

/*
|--------------------------------------------------------------------------
| Parkings controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\ChargingstationBike;
use Illuminate\Http\Request;

/**
 *
 */
class BikeInChargingStationController extends Controller
{

    public function showAllBikesInChargingstation($chargingstationId)
    {
        return response()->json(ChargingstationBike::where('chargingstation_id', $chargingstationId)->get());
    }

    public function showBikeInChargingStation($bikeId)
    {
        return response()->json(ChargingstationBike::where('bike_id', $bikeId)->get());
    }

    public function add(Request $request)
    {
        /*
         * Requires:
         *  "chargingstation_id"
         *  "bike_id"
         *  "arrival"
        */
        $chargingstationBike = new ChargingstationBike();
        try {
            $bike = $chargingstationBike::create($request->all());
            return response()->json($bike, 201);
        } catch (\Exception $e) {
            return response('Bike already in placed in a chargingstation.', 500);
        }

    }

    public function remove($bikeId)
    {
        ChargingstationBike::where('bike_id', $bikeId)->firstOrFail()->delete();
        return response('Bike removed', 200);
    }
}
