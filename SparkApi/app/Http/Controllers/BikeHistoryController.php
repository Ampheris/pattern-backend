<?php

/*
|--------------------------------------------------------------------------
| Bike history controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Bikelog;
use App\Http\Controllers\BikeController;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 *
 */
class BikeHistoryController extends Controller
{
    public function showAll()
    {
        $bikelog = new Bikelog();
        return response()->json($bikelog::all());
    }
    public function showOneBikesHistory($bikeId)
    {
        return response()->json(Bikelog::where('bike_id', $bikeId)->get());
    }

    public function showOneUsersBikeHistory($customerId)
    {
        return response()->json(Bikelog::where('customer_id', $customerId)->get());
    }

    public function showSpecifikBikeHistory($historyId)
    {
        return response()->json(Bikelog::find($historyId));
    }

    public function start(Request $request)
    {
        $bikesLastRide = Bikelog::where('bike_id', $request->input('bike_id'))->latest()->first();
        $usersLastBikeRide = Bikelog::where('customer_id', $request->input('customer_id'))->latest()->first();
        //Kontrollera att senaste påbörjade åkturen är avslutat, innan en ny påbörjas
        if ($bikesLastRide && is_null($bikesLastRide['stop_time'])) {
            return response('Someone else is using the bike.', 500);
        }

        if ($usersLastBikeRide && is_null($usersLastBikeRide['stop_time'])) {
            return response('This user is already using a bike', 500);
        }

        $bikelog = new Bikelog();
        date_default_timezone_set('Europe/Stockholm');
        $date = date('Y-m-d h:i:s', time());
        $request['start_time'] = date('Y-m-d h:i:s', time());
        $bikelog = $bikelog::create($request->all());

        //Ändra status till tillgänglig på den cykel som nu startar.
        BikeController::changeStatusOnBike($request->input('bike_id'), 'upptagen');
        return response()->json($bikelog, 201);
    }

    public function stop($customerId, Request $request)
    {
        date_default_timezone_set('Europe/Stockholm');
        $date = date('Y-m-d h:i:s', time());

        $usersLastBikeRide = Bikelog::where('customer_id', $customerId)->latest()->first();

        if ($usersLastBikeRide && !is_null($usersLastBikeRide['stop_time'])) {
            return response('This user is not using a bike', 500);
        }


        $request['stop_time'] = $date;
        $usersLastBikeRide->update($request->all());

        //Ändra status till tillgänglig på den cykel som nu stannar.
        BikeController::changeStatusOnBike($usersLastBikeRide['bike_id'], 'tillgänglig');

        return response()->json($usersLastBikeRide, 200);
    }
}
