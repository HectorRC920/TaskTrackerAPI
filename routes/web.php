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
$router->group(['prefix' => 'api/v1/'], function () use ($router) {
    //<----------------------Task------------------------>
    $router->get('/tasks','TaskController@index' );
    $router->post('/task/create', 'TaskController@store');
    $router->post('/task/assign', 'TaskController@assign');
    $router->post('/task/start/{id}', 'TaskController@start');
    $router->post('/task/stop/{id}', 'TaskController@stop');
    $router->put('/task/delete/{id}','TaskController@delete');
    // <---------------------Project--------------------->
    $router->get('/projects','ProjectController@index');
    $router->post('/project/create','ProjectController@store');
    $router->get('/project/report/{id}','ProjectController@report');
    $router->put('/project/delete/{id}','ProjectController@delete');
});
