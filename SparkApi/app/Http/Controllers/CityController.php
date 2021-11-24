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
        $cityzone = new Cityzone();
        return response()->json($cityzone::all());
    }

    public function create(Request $request)
    {
        /**
         * Requires:
         * "X"
         * "Y"
         * "Radius"
         * "City"
         */
         $cityzone = new Cityzone();
         $city = $cityzone::create($request->all());

        return response()->json($city, 201);
    }

    public function showOneCity($cityId)
    {
        $cityzone = new Cityzone();
        return response()->json($cityzone::find($cityId));
    }

    public function update($cityId, Request $request)
    {
        $cityzone = new Cityzone();
        $city = $cityzone::findOrFail($cityId);
        $city->update($request->all());

        return response()->json($city, 200);
    }
}
