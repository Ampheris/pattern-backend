<?php

/*
|--------------------------------------------------------------------------
| Bike controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

/**
*
 */
class BikeController extends Controller
{

    public function showAllBikes()
    {
        $bike = new Bike();
        return response()->json($bike::all());
    }

    public function showOneBike($bikeId)
    {
        $bike = new Bike();
        return response()->json($bike::find($bikeId));
    }

    public function create(Request $request)
    {
        /*
         * Requires:
         *  "status"
         *  "battery"
         *  "velocity"
         *  "X"
         *  "Y"
        */
        $bike = new Bike();
        $bike = $bike::create($request->all());

        return response()->json($bike, 201);
    }

    public function update($bikeId, Request $request)
    {
        $bike = new Bike();
        $bike = $bike::findOrFail($bikeId);
        $bike->update($request->all());

        return response()->json($bike, 200);
    }

    public function delete($bikeId)
    {
        $bike = new Bike();
        $bike::findOrFail($bikeId)->delete();
        return response('Deleted Successfully', 200);
    }
}
