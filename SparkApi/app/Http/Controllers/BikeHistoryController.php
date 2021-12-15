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
use App\Models\User;
use App\Models\Subscription;
use App\Models\ChargingstationBike;
use App\Models\ParkingspaceBike;

use App\Http\Controllers\BikeController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $bikelog = new Bikelog();
        return response()->json($bikelog::where('bike_id', $bikeId)->get());
    }

    public function showOneUsersBikeHistory($customerId)
    {
        $bikelog = DB::table('bikelogs')
                    ->leftJoin('orders', 'bikelogs.id', '=', 'orders.bikehistory_id')
                    ->select('bikelogs.*', 'orders.*')
                    ->where('bikelogs.customer_id', $customerId)
                    ->orderBy('created_at', 'desc')
                    ->get();
        return response()->json($bikelog);
    }

    public function showSpecifikBikeHistory($historyId)
    {
        $bikelog = new Bikelog();
        $bikelog = DB::table('bikelogs')
                    ->leftJoin('orders', 'bikelogs.id', '=', 'orders.bikehistory_id')
                    ->select('bikelogs.*', 'orders.*')
                    ->where('bikelogs.id', $historyId)
                    ->get();
        return response()->json($bikelog);
    }

    public function showUsersActiveBikeHistory($customerId)
    {
        $bikelog = new Bikelog();
        $activeBikeRide = $bikelog::where('customer_id', $customerId)->latest()->first();
        if (is_null($activeBikeRide->stop_time)) {
            return response()->json($activeBikeRide);
        }

        return false;
    }

    /**
     *  Function to start a bikeride, after first making sure that the bike is not already in use, or
     *  the user is using another bike.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Request $request)
    {
        $bikelog = new Bikelog();
        $bikesLastRide = $bikelog::where('bike_id', $request->input('bike_id'))->latest()->first();

        $usersLastBikeRide = $bikelog::where('customer_id', $request->input('customer_id'))->latest()->first();

        //Kontrollera att cykelns senaste påbörjade åkturen är avslutat, innan en ny påbörjas
        if ($bikesLastRide && is_null($bikesLastRide['stop_time'])) {
            return response()->json(['message' => 'Someone else is using the bike.'], 500);
        }
        //Kontrollera att användarens senaste påbörjade åkturen är avslutat, innan en ny påbörjas
        if ($usersLastBikeRide && is_null($usersLastBikeRide['stop_time'])) {
            return response()->json(['message' => 'This user is already using a bike'], 500);
        }

        $carbon = new Carbon();
        $date = $carbon::now();

        $bike = new Bike();
        $bike = $bike::find($request->input('bike_id'));

        $request['start_time'] = $date;
        $request['start_x'] = $bike['X'];
        $request['start_y'] = $bike['Y'];

        $bikelog = $bikelog::create($request->all());

        //ta bort fron laddstation/parkering ifall cykeln står på en
        $chargingstation = new ChargingstationBike();
        $parkingspace = new ParkingspaceBike();

        try {
            $chargingstation::where('bike_id', $bike['id'])->firstOrFail()->delete();
            $parkingspace::where('bike_id', $bike['id'])->firstOrFail()->delete();
        } catch (\Exception $e) {

        }

        //Ändra status till available på den cykel som nu startar.
        $bikeController = new BikeController();
        $bikeController->changeStatusOnBike($request->input('bike_id'), 'unavailable');
        return response()->json($bikelog, 201);
    }

    /**
     * Function to end a bikeride and create an order for that bike ride.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stop($customerId)
    {
        $carbon = new Carbon();
        $date = $carbon::now();

        $usersLastBikeRide = new Bikelog();
        $usersLastBikeRide = Bikelog::where('customer_id', $customerId)->latest()->first();

        //Kontrollera att användaren har en aktiv åktur
        if ($usersLastBikeRide && !is_null($usersLastBikeRide['stop_time'])) {
            return response()->json(['message' => 'This user is not using a bike'], 500);
        }

        $bike = new Bike();
        $bike = $bike::find($usersLastBikeRide['bike_id']);

        $data = [
            'stop_time' => $date,
            'stop_x' => $bike['X'],
            'stop_y' => $bike['Y']
        ];

        //Ändra status till available på den cykel som nu stannar.
        $bikeController = new BikeController();
        $bikeController->changeStatusOnBike($usersLastBikeRide['bike_id'], 'available');

        //Kolla så användaren inte har en aktiv subscription, och i så fall skapa en order
        $subscription = new Subscription();
        $subscription = $subscription::where('customer_id', $customerId)->latest()->first();
        // var_dump($subscription['id']);
        if (is_null($subscription) || (!is_null($subscription['cancelation_date']) && $subscription['cancelation_date'] > $subscription['renewal_date'])) {
            $user = new User();
            $user = $user::findOrFail($customerId);

            $bikeRidePrice = $this->calculatePrice($usersLastBikeRide, $bike);
            $userBalance = $user['balance'];

            //Kontrollera att användaren har tillräckligt med pengar för att betala åkturen
            if ($bikeRidePrice > $userBalance) {
                return response()->json(['message' => 'User does not have enough money to pay for bikeride.'], 500);
            }

            $user->update(['balance' => $userBalance - $bikeRidePrice]);

            //Skapa en order för åkturen
            $orderData = [
                'customer_id' => $customerId,
                'order_date' => $date,
                'total_price' => $bikeRidePrice,
                'bikehistory_id' => $usersLastBikeRide['id']
            ];

            $order = new Order();
            $order = $order::create($orderData);
        }

        if ($this->checkIfInsideParkingZone($bike)) {
            $data['inside_parking_area'] = 1;
            $parkingspaceBike = new ParkingspaceBike();
            $bike = $parkingspaceBike::create($this->checkIfInsideParkingZone($bike));
        }

        if ($this->checkIfInsideChargingzoneZone($bike)) {
            $data['inside_parking_area'] = 1;
            $chargingstationBike = new ChargingstationBike();
            $bike = $chargingstationBike::create($this->checkIfInsideChargingzoneZone($bike));
        }

        $usersLastBikeRide->update($data);
        return response()->json($usersLastBikeRide, 200);
    }


    /*
     * Function to determine if the bike is located within a parkingspace or chargingstation -> returns true, else false.
     *
     * @return bool
     */
    public function checkIfInsideParkingZone($bike)
    {
        $parkingspace = new Parkingspace();
        $parkingspaces = $parkingspace::all();


        foreach ($parkingspaces as $key => $value) {
            $longA     = $value['X'] * (M_PI / 180); // M_PI is a php constant
            $latA     = $value['Y'] * (M_PI / 180);
            $longB     = $bike['X'] * (M_PI / 180);
            $latB     = $bike['Y'] * (M_PI / 180);

            $subBA       = bcsub(strval($longB), strval($longA), 20);
            $cosLatA     = cos($latA);
            $cosLatB     = cos($latB);
            $sinLatA     = sin($latA);
            $sinLatB     = sin($latB);

            $diffBikeToCenter = 6371 * acos($cosLatA * $cosLatB * cos(floatval($subBA)) + $sinLatA * $sinLatB) * 1000;

            //110000 konverterar från koordinat till meter
            if (abs($diffBikeToCenter) < $value['radius'] * 110000) {
                $data = [
                    'parkingspace_id' => $value['id'],
                    'bike_id' => $bike['id']
                ];
                return $data;
            }
        }
        return false;
    }

    public function checkIfInsideChargingzoneZone($bike)
    {
        $chargingstation = new Chargingstation();
        $chargingstations = $chargingstation::all();

        foreach ($chargingstations as $key => $value) {
            $longA     = $value['X'] * (M_PI / 180); // M_PI is a php constant
            $latA     = $value['Y'] * (M_PI / 180);
            $longB     = $bike['X'] * (M_PI / 180);
            $latB     = $bike['Y'] * (M_PI / 180);

            $subBA       = bcsub(strval($longB), strval($longA), 20);
            $cosLatA     = cos($latA);
            $cosLatB     = cos($latB);
            $sinLatA     = sin($latA);
            $sinLatB     = sin($latB);

            $diffBikeToCenter = 6371 * acos($cosLatA * $cosLatB * cos(floatval($subBA)) + $sinLatA * $sinLatB) * 1000;

            if (abs($diffBikeToCenter) < $value['radius'] * 110000) {
                $data = [
                    'chargingstation_id' => $value['id'],
                    'bike_id' => $bike['id']
                ];
                return $data;
            }
        }
        return false;
    }

    /**
     * Function to calculate price of a ride, depending on time and parking
     *
     * @return int
     */
    public function calculatePrice($bikeride, $bike)
    {
        //skillnad i tid i minuter
        $carbon = new Carbon();
        $timeDiff = $carbon::parse($bikeride['stop_time'])->diffInSeconds($carbon::parse($bikeride['start_time'])) / 60;
        $taxForTime = $timeDiff * 5;

        //Grundtaxa beror på parkering
        if ($this->checkIfInsideParkingZone($bike) || $this->checkIfInsideChargingzoneZone($bike)) {
            $totalTax = $taxForTime + 10;
            return $totalTax;
        }

        $bikeride['inside_parking_area'] = 0;
        $totalTax = $taxForTime + 20;
        return $totalTax;
    }
}
