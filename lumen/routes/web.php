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
    //Importa os produos que estão no CSV
    $router->get('/importar-produtos', 'ProdutoController@importarProdutos');
    //Lista todos os produtos
    $router->get('/', 'ProdutoController@index');
    //Exibe os detalhes de 1 produto a busca pode ser feita por ID ou SKU
    $router->get('/{id}', 'ProdutoController@show');
    //Insere um novo produto passando os parametros: client, sku, quantity
    $router->post('/', 'ProdutoController@insert');
    //Altera todos os dados de um produto
    $router->put('/{id}', 'ProdutoController@update');
    //Remove um produto
    $router->delete('/{id}', 'ProdutoController@delete');
    //Altera a quantidade de estoque de um produto
    $router->patch('/{id}', 'ProdutoController@alteraQuantity');
    //Adiciona estoque a um produto
    $router->patch('/adicionar/{id}', 'ProdutoController@adicionarQuantity');
    //Diminui estoque de um produto
    $router->patch('/remover/{id}', 'ProdutoController@removerQuantity');
});

$router->group(['prefix' => 'reserva'], function () use ($router) {
    //Lista todas as reservas realizadas
    $router->get('/', 'ReservaController@index');
    //Exibe os detalhes de uma reserva
    $router->get('/{id}', 'ReservaController@show');
    //Insere uma nova reservar
    $router->post('/', 'ReservaController@insert');
    //Remove uma reserva
    $router->delete('/{id}', 'ReservaController@delete');
});