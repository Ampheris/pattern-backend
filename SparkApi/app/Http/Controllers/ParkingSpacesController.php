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

    function showAllParkingSpaces()
    {
        return response()->json(Parkingspace::all());
    }

    public function showOneParkingSpace($id)
    {
        return response()->json(Parkingspace::find($id));
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
        $bike = Parkingspace::create($request->all());

        return response()->json($bike, 201);
    }

    public function update($id, Request $request)
    {
        $bike = Parkingspace::findOrFail($id);
        $bike->update($request->all());

        return response()->json($bike, 200);
    }
}
