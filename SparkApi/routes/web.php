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
    //city
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
    | Chargingstations
    |----------------------------------------------------------------------
    */
    $router->get('chargingstations',  ['uses' => 'ChargingStationsController@showAllChargingstations']);
    $router->get('chargingstations/{id}', ['uses' => 'ChargingStationsController@showOneChargingstation']);
    $router->post('chargingstations', ['uses' => 'ChargingStationsController@create']);
    $router->put('chargingstations/{id}', ['uses' => 'ChargingStationsController@update']);
    /*
    |----------------------------------------------------------------------
    | Bikehistory
    |----------------------------------------------------------------------
    */
    $router->get('bikehistory/bike/{id}', ['uses' => 'BikeHistoryController@showOneBikesHistory']);
    $router->get('bikehistory/user/{id}', ['uses' => 'BikeHistoryController@showOneUsersBikeHistory']);
});
