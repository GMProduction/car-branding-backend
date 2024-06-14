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
    return response()->json([
        'app_name' => env('APP_NAME'),
        'version' => env('APP_VERSION')
    ], 200);
});

$router->group(['prefix' => 'admin', 'namespace' => 'Admin'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('/sign-in', 'AuthController@sign_in');
    });

    $router->group(['prefix' => 'car-type'], function () use ($router) {
        $router->get('/', 'CarTypeController@index');
        $router->post('/', 'CarTypeController@index');
        $router->get('/{id}', 'CarTypeController@getDataByID');
    });

    $router->group(['prefix' => 'driver'], function () use ($router) {
        $router->get('/', 'DriverController@index');
        $router->post('/', 'DriverController@index');
        $router->get('/{id}', 'DriverController@getDataByID');
    });
});

$router->group(['prefix' => 'driver', 'namespace' => 'Driver'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('/sign-in', 'AuthController@sign_in');
    });
});
