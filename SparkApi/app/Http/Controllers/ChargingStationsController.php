<?php

/*
|--------------------------------------------------------------------------
| Chargingstations controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Chargingstation;
use Illuminate\Http\Request;

/**
 *
 */
class ChargingStationsController extends Controller
{

    public function showAllChargingstations()
    {
        $chargingstation = new Chargingstation();
        return response()->json($chargingstation::all());
    }

    public function showOneChargingstation($chargingstationId)
    {
        $chargingstation = new Chargingstation();
        return response()->json($chargingstation::find($chargingstationId));
    }

    public function create(Request $request)
    {
        /*
         * Requires:
         *  "X_POS"
         *  "Y_POS"
         *  "available"
         *  "radie"
         *  "name"
        */
        $chargingstation = new Chargingstation();
        $bike = $chargingstation::create($request->all());

        return response()->json($bike, 201);
    }

    public function update($chargingstationId, Request $request)
    {
        $chargingstation = new Chargingstation();
        $bike = $chargingstation::findOrFail($chargingstationId);
        $bike->update($request->all());

        return response()->json($bike, 200);
    }
}
