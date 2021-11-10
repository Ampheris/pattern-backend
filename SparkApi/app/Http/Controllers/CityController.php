<?php
/*
|--------------------------------------------------------------------------
| City controller
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Cityzone;
use App\Models\Bike;
use Illuminate\Http\Request;

/**
 *
 */
class CityController extends Controller
{

    public function showAllCities()
    {
        return response()->json(Cityzone::all());
    }

    public function create(Request $request) {
        /**
         * Requires:
         * "X"
         * "Y"
         * "Radius"
         * "City"
         */
        $city = Cityzone::create($request->all());

        return response()->json($city, 201);
    }

    public function showOneCity($id) {
        return response()->json(Cityzone::find($id));
    }

    public function update($id, Request $request) {
        $city = Cityzone::findOrFail($id);
        $city->update($request->all());

        return response()->json($city, 200);
    }

}
