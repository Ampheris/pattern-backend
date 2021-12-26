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

$router->post('sparkapi/v1/apiuser', ['uses' => 'ApiUserController@create']);
// $router->get('sparkapi/v1/bikes', ['uses' => 'BikeController@showAllBikes', 'middleware' => 'auth']);

// $router->get('sparkapi/v1/login/github/callback', ['as' => 'login.github.callback', 'uses' => 'SocialController@Callback']);
// $router->get('sparkapi/v1/login/github', ['as' => 'login.github', 'uses' => 'SocialController@redirect']);


$router->group(['middleware' => 'oauth', 'prefix' => 'sparkapi/v1'], function () use ($router) {
    /*
    |----------------------------------------------------------------------
    | Login via socials
    |----------------------------------------------------------------------
    */
    $router->get('login/github', ['as' => 'login.github', 'uses' => 'SocialController@redirect']);
    $router->get('login/github/callback', ['as' => 'login.github.callback', 'uses' => 'SocialController@Callback']);
    // $router->get('login/admin', ['as' => 'login.admin', 'uses' => 'SocialController@Admin']);
    /*
    |----------------------------------------------------------------------
    | City
    |----------------------------------------------------------------------
    */
    $router->get('users', ['uses' => 'UserController@showAllUsers']);
    $router->get('users/get', ['uses' => 'UserController@showOneUser']);
    $router->patch('users/balance', ['uses' => 'UserController@update']);
    $router->post('users', ['uses' => 'UserController@create']);
    /*
    |----------------------------------------------------------------------
    | City
    |----------------------------------------------------------------------
    */
    $router->get('cities', ['uses' => 'CityController@showAllCities']);
    $router->get('cities/{cityId}', ['uses' => 'CityController@showOneCity']);
    $router->put('cities/{cityId}', ['uses' => 'CityController@update']);
    $router->post('cities', ['uses' => 'CityController@create']);
    /*
    |----------------------------------------------------------------------
    | Bikes
    |----------------------------------------------------------------------
    */
    $router->get('bikes', ['uses' => 'BikeController@showAllBikes']);
    $router->get('bikes/{bikeId}', ['uses' => 'BikeController@showOneBike']);
    $router->post('bikes', ['uses' => 'BikeController@create']);
    $router->delete('bikes/{bikeId}', ['uses' => 'BikeController@delete']);
    $router->put('bikes/{bikeId}', ['uses' => 'BikeController@update']);
    /*
    |----------------------------------------------------------------------
    | Bikes in chargingstations
    |----------------------------------------------------------------------
    */
    $router->get('chargingstation/bikes/{chargingstationId}', ['uses' => 'BikeInChargingStationController@showAllBikesInChargingstation']);
    $router->get('chargingstation/bike/{bikeId}', ['uses' => 'BikeInChargingStationController@showBikeInChargingStation']);
    $router->post('chargingstation/bike', ['uses' => 'BikeInChargingStationController@add']);
    $router->delete('chargingstation/bike/{bikeId}', ['uses' => 'BikeInChargingStationController@remove']);
    /*
    |----------------------------------------------------------------------
    | Chargingstations
    |----------------------------------------------------------------------
    */
    $router->get('chargingstations', ['uses' => 'ChargingStationsController@showAllChargingstations']);
    $router->get('chargingstations/{chargingstationId}', ['uses' => 'ChargingStationsController@showOneChargingstation']);
    $router->post('chargingstations', ['uses' => 'ChargingStationsController@create']);
    $router->put('chargingstations/{chargingstationId}', ['uses' => 'ChargingStationsController@update']);
    /*
    |----------------------------------------------------------------------
    | Bikes in parkingspace
    |----------------------------------------------------------------------
    */
    $router->get('parkingspace/bikes/{parkingspaceId}', ['uses' => 'BikeInParkingSpaceController@showAllBikesInParkingSpace']);
    $router->get('parkingspace/bike/{bikeId}', ['uses' => 'BikeInParkingSpaceController@showBikeInParkingSpace']);
    $router->post('parkingspace/bike', ['uses' => 'BikeInParkingSpaceController@add']);
    $router->delete('parkingspace/bike/{bikeId}', ['uses' => 'BikeInParkingSpaceController@remove']);
    /*
    |----------------------------------------------------------------------
    | parkingspaces
    |----------------------------------------------------------------------
    */
    $router->get('parkingspaces', ['uses' => 'ParkingSpacesController@showAllParkingSpaces']);
    $router->get('parkingspaces/{parkingspaceId}', ['uses' => 'ParkingSpacesController@showOneParkingSpace']);
    $router->post('parkingspaces', ['uses' => 'ParkingSpacesController@create']);
    $router->put('parkingspaces/{parkingspaceId}', ['uses' => 'ParkingSpacesController@update']);
    /*
    |----------------------------------------------------------------------
    | Bikehistory
    |----------------------------------------------------------------------
    */
    $router->get('bikehistory', ['uses' => 'BikeHistoryController@showAll']);
    $router->get('bikehistory/bike/{bikeId}', ['uses' => 'BikeHistoryController@showOneBikesHistory']);
    $router->get('bikehistory/user', ['uses' => 'BikeHistoryController@showOneUsersBikeHistory']);
    $router->get('bikehistory/user/active', ['uses' => 'BikeHistoryController@showUsersActiveBikeHistory']);
    $router->get('bikehistory/stop', ['uses' => 'BikeHistoryController@stop']);
    $router->get('bikehistory/start', ['uses' => 'BikeHistoryController@start']);
    $router->get('bikehistory/{historyId}', ['uses' => 'BikeHistoryController@showSpecifikBikeHistory']);
    //Använder userId, för tänker att en användare bara kommer kunna ha igång en cykel åt gången.
    /*
    |----------------------------------------------------------------------
    | Orders
    |----------------------------------------------------------------------
    */
    $router->get('orders', ['uses' => 'OrdersController@ShowAllOrders']);
    $router->post('orders', ['uses' => 'OrdersController@create']);
    $router->get('orders/user', ['uses' => 'OrdersController@ShowCustomersOrders']);
    $router->get('orders/{orderId}', ['uses' => 'OrdersController@ShowSingleOrder']);
    $router->get('orders/history/{bikehistoryId}', ['uses' => 'OrdersController@ShowOrderForBikeride']);

    /*
    |----------------------------------------------------------------------
    | Order
    |----------------------------------------------------------------------
    */
    $router->get('order/{orderId}', ['uses' => 'OrdersController@ShowOneOrder']);
    /*
    |----------------------------------------------------------------------
    | Subscription
    |----------------------------------------------------------------------
    */
    $router->get('subscriptions', ['uses' => 'SubscriptionsController@ShowAllSubscriptions']);
    $router->get('subscriptions/start', ['uses' => 'SubscriptionsController@start']);
    $router->get('subscriptions/stop', ['uses' => 'SubscriptionsController@stop']);
    $router->patch('subscriptions/renew', ['uses' => 'SubscriptionsController@renew']);
    $router->get('subscriptions/user', ['uses' => 'SubscriptionsController@ShowCustomersCurrentSubscription']);
    // $router->get('subscriptions/all/{customerId}', ['uses' => 'SubscriptionsController@ShowAllCustomersSubscriptions']);
});
