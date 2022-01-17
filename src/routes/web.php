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

$router->group(['prefix' => 'v1'], function () use ($router) {

    // Order
    $router->group(['prefix' => 'order', 'namespace'], function () use ($router) {
        $router->get('', '\LeaRecordShop\Order\Controller@list');
        $router->post('', '\LeaRecordShop\Order\Controller@create');
        $router->delete('{id}', '\LeaRecordShop\Order\Controller@delete');
        $router->put('{id}', '\LeaRecordShop\Order\Controller@update');
    });
});