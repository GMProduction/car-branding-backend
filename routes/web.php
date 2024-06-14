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

$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->group(['prefix' => 'auth', 'namespace' => 'Admin'], function () use ($router) {
        $router->post('/sign-in', 'AuthController@sign_in');
    });
});
