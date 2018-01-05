<?php

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

$app->get('/', function() use ($app) {
    return $app->version();
});

//
$app->get('vehicles/{modelYear}/{manufacturer}/{model}', ['as' => 'getAllVehicles', 'uses' => 'VehiclesController@filter']);

$app->post('vehicles', ['as' => 'findAllVehicles', 'uses' => 'VehiclesController@filter']);