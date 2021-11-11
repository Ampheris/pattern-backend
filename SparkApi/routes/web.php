<?php

/** @var \Laravel\Lumen\Routing\Router $router */
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'sparkapi/v1'], function () use ($router) {
    /*
    |----------------------------------------------------------------------
    | City
    |----------------------------------------------------------------------
    */
    $router->get('cities', ['uses' => 'CityController@showAllCities']);
    $router->get('cities/{id}', ['uses' => 'CityController@showOneCity']);
    $router->put('cities/{id}', ['uses' => 'CityController@update']);
    $router->post('cities', ['uses' => 'CityController@create']);
    /*
    |----------------------------------------------------------------------
    | Bikes
    |----------------------------------------------------------------------
    */
    $router->get('bikes',  ['uses' => 'BikeController@showAllBikes']);
    $router->get('bikes/{id}', ['uses' => 'BikeController@showOneBike']);
    $router->post('bikes', ['uses' => 'BikeController@create']);
    $router->delete('bikes/{id}', ['uses' => 'BikeController@delete']);
    $router->put('bikes/{id}', ['uses' => 'BikeController@update']);
    /*
    |----------------------------------------------------------------------
    | Bikes in chargingstations
    |----------------------------------------------------------------------
    */
    $router->get('chargingstation/bikes/{chargingstation_id}',  ['uses' => 'BikeInChargingStationController@showAllBikesInChargingstation']);
    $router->get('chargingstation/bike/{bike_id}', ['uses' => 'BikeInChargingStationController@showBikeInChargingStation']);
    $router->post('chargingstation/bike', ['uses' => 'BikeInChargingStationController@add']);
    $router->delete('chargingstation/bike/{bike_id}', ['uses' => 'BikeInChargingStationController@remove']);
    /*
    |----------------------------------------------------------------------
    | Chargingstations
    |----------------------------------------------------------------------
    */
    $router->get('chargingstations',  ['uses' => 'ChargingStationsController@showAllChargingstations']);
    $router->get('chargingstations/{id}', ['uses' => 'ChargingStationsController@showOneChargingstation']);
    $router->post('chargingstations', ['uses' => 'ChargingStationsController@create']);
    $router->put('chargingstations/{id}', ['uses' => 'ChargingStationsController@update']);
    /*
    |----------------------------------------------------------------------
    | Bikes in parkingspace
    |----------------------------------------------------------------------
    */
    $router->get('parkingspace/bikes/{parkingspace_id}',  ['uses' => 'BikeInParkingSpaceController@showAllBikesInParkingSpace']);
    $router->get('parkingspace/bike/{bike_id}', ['uses' => 'BikeInParkingSpaceController@showBikeInParkingSpace']);
    $router->post('parkingspace/bike', ['uses' => 'BikeInParkingSpaceController@add']);
    $router->delete('parkingspace/bike/{bike_id}', ['uses' => 'BikeInParkingSpaceController@remove']);
    /*
    |----------------------------------------------------------------------
    | parkingspaces
    |----------------------------------------------------------------------
    */
    $router->get('parkingspaces',  ['uses' => 'ParkingSpacesController@showAllParkingSpaces']);
    $router->get('parkingspaces/{id}', ['uses' => 'ParkingSpacesController@showOneParkingSpace']);
    $router->post('parkingspaces', ['uses' => 'ParkingSpacesController@create']);
    $router->put('parkingspaces/{id}', ['uses' => 'ParkingSpacesController@update']);
    /*
    |----------------------------------------------------------------------
    | Bikehistory
    |----------------------------------------------------------------------
    */
    $router->get('bikehistory/bike/{bike_id}', ['uses' => 'BikeHistoryController@showOneBikesHistory']);
    $router->get('bikehistory/user/{customer_id}', ['uses' => 'BikeHistoryController@showOneUsersBikeHistory']);

    /*
    |----------------------------------------------------------------------
    | Orders
    |----------------------------------------------------------------------
    */
    $router->get('orders',  ['uses' => 'OrdersController@ShowAllOrders']);
    $router->post('orders', ['uses' => 'OrdersController@create']);
    $router->get('orders/{customer_id}', ['uses' => 'OrdersController@ShowCustomersOrders']);

    /*
    |----------------------------------------------------------------------
    | Order
    |----------------------------------------------------------------------
    */
    $router->get('order/{order_id}', ['uses' => 'OrdersController@ShowOneOrder']);
});
