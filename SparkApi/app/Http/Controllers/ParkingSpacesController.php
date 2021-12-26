<?php

/*
|--------------------------------------------------------------------------
| Parkings controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Parkingspace;
use Illuminate\Http\Request;

/**
 *
 */
class ParkingSpacesController extends Controller
{

    public function showAllParkingSpaces()
    {
        $parkingspace = new Parkingspace();
        return response()->json($parkingspace::all());
    }

    public function showOneParkingSpace($parkingspaceId)
    {
        $parkingspace = new Parkingspace();
        return response()->json($parkingspace::find($parkingspaceId));
    }

    public function create(Request $request)
    {
        /*
         * Requires:
         *  "X_POS"
         *  "Y_POS"
         *  "radie"
         *  "name"
        */

        $parkingspace = new Parkingspace();
        $parkingspace = $parkingspace::create($request->all());

        return response()->json($parkingspace, 201);
    }

    public function update($parkingspaceId, Request $request)
    {
        $parkingspace = new Parkingspace();
        $parkingspace = $parkingspace::findOrFail($parkingspaceId);
        $parkingspace->update($request->all());

        return response()->json($parkingspace, 200);
    }
}
