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

      $router->get('bikes',  ['uses' => 'BikeController@showAllBikes']);
      $router->get('bikes/{id}', ['uses' => 'BikeController@showOneBike']);
      $router->post('bikes', ['uses' => 'BikeController@create']);
      $router->delete('bikes/{id}', ['uses' => 'BikeController@delete']);
      $router->put('bikes/{id}', ['uses' => 'BikeController@update']);
});
