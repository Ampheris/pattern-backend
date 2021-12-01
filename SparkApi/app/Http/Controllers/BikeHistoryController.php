<?php

/*
|--------------------------------------------------------------------------
| Bike history controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Bikelog;
use App\Models\Order;
use App\Models\Bike;
use App\Models\Chargingstation;
use App\Models\Parkingspace;

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

    public function showUsersActiveBikeHistory($customerId)
    {
        $activeBikeRide = new Bikelog();
        $activeBikeRide = $activeBikeRide::where('customer_id', $customerId)->latest()->first();
        if (is_null($activeBikeRide->stop_time)) {
            return response()->json($activeBikeRide);
        }

        return false;
    }

    public function start(Request $request)
    """
    Function to start a bikeride, after first making sure that the bike is not already in use, or
    the user is using another bike.
    """
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
        $date = Carbon::now();
        $request['start_time'] = $date;
        $bikelog = $bikelog::create($request->all());

        //Ändra status till tillgänglig på den cykel som nu startar.
        BikeController::changeStatusOnBike($request->input('bike_id'), 'upptagen');
        return response()->json($bikelog, 201);
    }

    public function stop($customerId, Request $request)
    """
    Function to end a bikeride and create an order for that bike ride.
    """
    {
        $date = Carbon::now();
        $usersLastBikeRide = Bikelog::where('customer_id', $customerId)->latest()->first();

        if ($usersLastBikeRide && !is_null($usersLastBikeRide['stop_time'])) {
            return response('This user is not using a bike', 500);
        }

        $bike = Bike::find($usersLastBikeRide['bike_id']);

        $data = [
            'stop_time' => $date,
            'stop_x' => $bike['X'],
            'stop_y' => $bike['Y']
        ];

        $usersLastBikeRide->update($data);

        //Ändra status till tillgänglig på den cykel som nu stannar.
        BikeController::changeStatusOnBike($usersLastBikeRide['bike_id'], 'tillgänglig');


        $orderData = [
            'customer_id' => $customerId,
            'order_date' => $date,
            'total_price' => $this->calculatePrice($usersLastBikeRide, $bike),
            'bikehistory_id' => $usersLastBikeRide['id']
        ];

        $order = new Order();
        $order = $order::create($orderData);

        return response()->json($usersLastBikeRide, 200);
    }

    public function checkIfInsideZone($bike)
    """
    Function to determine if the bike is located within a parkingspace or chargingstation -> returns true, else false.
    """
    {
        $chargingstation = new Chargingstation();
        $chargingstations = $chargingstation::all();

        $parkingspace = new Parkingspace();
        $parkingspaces = $parkingspace::all();


        foreach ($parkingspaces as $key => $value) {
            $longA     = $value['x_pos']*(M_PI/180); // M_PI is a php constant
            $latA     = $value['y_pos']*(M_PI/180);
            $longB     = $bike['X']*(M_PI/180);
            $latB     = $bike['Y']*(M_PI/180);

            $subBA       = bcsub ($longB, $longA, 20);
            $cosLatA     = cos($latA);
            $cosLatB     = cos($latB);
            $sinLatA     = sin($latA);
            $sinLatB     = sin($latB);

            $diffBikeToCenter = 6371*acos($cosLatA*$cosLatB*cos($subBA)+$sinLatA*$sinLatB)*1000;

            if (abs($diffBikeToCenter) < $value['radius']) {
                return true;
            }
        }
        foreach ($chargingstations as $key => $value) {
            $longA     = $value['x_pos']*(M_PI/180); // M_PI is a php constant
            $latA     = $value['y_pos']*(M_PI/180);
            $longB     = $bike['X']*(M_PI/180);
            $latB     = $bike['Y']*(M_PI/180);

            $subBA       = bcsub ($longB, $longA, 20);
            $cosLatA     = cos($latA);
            $cosLatB     = cos($latB);
            $sinLatA     = sin($latA);
            $sinLatB     = sin($latB);

            $diffBikeToCenter = 6371*acos($cosLatA*$cosLatB*cos($subBA)+$sinLatA*$sinLatB)*1000;

            if (abs($diffBikeToCenter) < $value['radius']) {
                return true;
            }
        }
        return false;
    }

    public function calculatePrice($bikeride, $bike)
    """
    Function to calculate the price for a bike ride. The price depends on on time and where the bike is parked.
    """
    {
        //skillnad i tid i minuter
        $timeDiff = Carbon::parse($bikeride['stop_time'])->diffInSeconds(Carbon::parse($bikeride['start_time'])) / 60;
        $taxForTime = $timeDiff * 5;
        //Grundtaxa beror på parkering
        if ($this->checkIfInsideZone($bike)) {
            $totalTax = $taxForTime + 10;
        } else {
            $totalTax = $taxForTime + 20;
        }

        return $totalTax;
    }
}
