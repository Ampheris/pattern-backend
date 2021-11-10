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

    function showAllChargingstations()
    {
        return response()->json(Chargingstation::all());
    }

    public function showOneChargingstations($id)
    {
        return response()->json(Chargingstation::find($id));
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
        $bike = Chargingstation::create($request->all());

        return response()->json($bike, 201);
    }

    public function update($id, Request $request)
    {
        $bike = Chargingstation::findOrFail($id);
        $bike->update($request->all());

        return response()->json($bike, 200);
    }
}
