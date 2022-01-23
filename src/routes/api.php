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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        // Order
        $router->group(['prefix' => 'order', 'namespace'], function () use ($router) {
            $router->get('', 'Api\V1\OrderController@list');
            $router->post('', 'Api\V1\OrderController@create');
            $router->delete('{id}', 'Api\V1\OrderController@delete');
            $router->put('{id}', 'Api\V1\OrderController@update');
        });
        // Record
        $router->group(['prefix' => 'record', 'namespace'], function () use ($router) {
            $router->get('', 'Api\V1\RecordController@list');
            $router->post('', 'Api\V1\RecordController@create');
            $router->delete('{id}', 'Api\V1\RecordController@delete');
            $router->put('{id}', 'Api\V1\RecordController@update');
        });
        // User
        $router->group(['prefix' => 'record', 'namespace'], function () use ($router) {
            $router->get('', 'Api\V1\UserController@list');
            $router->post('', 'Api\V1\UserController@create');
            $router->delete('{id}', 'Api\V1\UserController@delete');
            $router->put('{id}', 'Api\V1\UserController@update');
        });
    });
});
