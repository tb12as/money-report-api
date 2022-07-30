<?php

use App\Models\Money;
use Illuminate\Support\Str;

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

// API Route
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        // Money API
        $router->group(['prefix' => 'money'], function () use ($router) {
            $router->get('/', 'MoneyController@index');
            $router->get('/report', 'MoneyController@report');
            $router->post('/', 'MoneyController@store');
        });
    });
});

// not found
// $router->get('{a:.*}', function ($a) {
//     return response()->json(['error' => 'INVALID_ROUTE'], 404);
// });
