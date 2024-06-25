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

    $router->group(['middleware' => ['auth', 'admin']], function () use ($router) {
        $router->group(['prefix' => 'car-type'], function () use ($router) {
            $router->get('/', 'CarTypeController@index');
            $router->post('/', 'CarTypeController@index');
            $router->get('/{id}', 'CarTypeController@findByID');
        });

        $router->group(['prefix' => 'driver'], function () use ($router) {
            $router->get('/', 'DriverController@index');
            $router->post('/', 'DriverController@index');
            $router->get('/{id}', 'DriverController@findByID');
            $router->post('/{id}', 'DriverController@findByID');
            $router->post('/{id}/soft-delete', 'DriverController@softDeleteDriver');
            $router->post('/{id}/restore', 'DriverController@restore');
            $router->post('/{id}/status', 'DriverController@patchBroadcastStatus');
            $router->post('/{id}/broadcast', 'DriverController@patchBroadcastName');
            $router->get('/{id}/report', 'DriverController@reportByDriver');
            $router->get('/export/excel', 'DriverController@exportToExcel');
        });

        $router->group(['prefix' => 'report'],  function() use ($router){
            $router->get('/', 'ReportController@index');
        });
    });

});

$router->group(['prefix' => 'driver', 'namespace' => 'Driver'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('/sign-in', 'AuthController@sign_in');
    });

    $router->group(['middleware' => ['auth', 'driver']], function () use ($router){

        $router->group(['prefix' => 'report'], function () use ($router) {
            $router->get('/', 'ReportController@index');
            $router->post('/', 'ReportController@index');
        });

        $router->group(['prefix' => 'profile'], function () use ($router) {
            $router->get('/', 'ProfileController@index');
        });
    });
});
