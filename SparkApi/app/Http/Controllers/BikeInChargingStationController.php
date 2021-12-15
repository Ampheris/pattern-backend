<?php

/*
|--------------------------------------------------------------------------
| Parkings controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\ChargingstationBike;
use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class BikeInChargingStationController extends Controller
{

    public function showAllBikesInChargingstation($chargingstationId)
    {
        $chargingstationBikes = DB::table('bikes')
                    ->leftJoin('chargingstation_bikes', 'bikes.id', '=', 'chargingstation_bikes.bike_id')
                    ->select('bikes.*', 'chargingstation_bikes.*')
                    ->where('chargingstation_bikes.chargingstation_id', $chargingstationId)
                    ->orderBy('created_at', 'desc')
                    ->get();
        return response()->json($chargingstationBikes);
        // return response()->json(ChargingstationBike::where('chargingstation_id', $chargingstationId)->get());
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
