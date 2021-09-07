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

$router->group(['prefix' => 'produto'], function () use ($router) {
    $router->get('/', 'ProdutoController@index');
    $router->get('/{id}', 'ProdutoController@show');
    $router->post('/', 'ProdutoController@insert');
    $router->put('/{id}', 'ProdutoController@update');
    $router->delete('/{id}', 'ProdutoController@delete');
    $router->patch('/{id}', 'ProdutoController@alteraQuantity');
    $router->patch('/adicionar/{id}', 'ProdutoController@adicionarQuantity');
    $router->patch('/remover/{id}', 'ProdutoController@removerQuantity');
});