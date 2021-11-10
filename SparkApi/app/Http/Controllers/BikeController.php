<?php
/*
|--------------------------------------------------------------------------
| Bike controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

/**
 *
 */
class BikeController extends Controller
{

    function showAllBikes()
    {
        return response()->json(Bike::all());
    }

    public function showOneBike($id)
    {
        return response()->json(Bike::find($id));
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
        $bike = Bike::create($request->all());

        return response()->json($bike, 201);
    }

    public function update($id, Request $request)
    {
        $bike = Bike::findOrFail($id);
        $bike->update($request->all());

        return response()->json($bike, 200);
    }

    public function delete($id)
    {
        Bike::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

}
