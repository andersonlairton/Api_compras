<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//rotas api
//clientes


Route::namespace('Api')->group(function () {
    
    Route::post('/cadastrarCliente', 'ClienteController@create');
    Route::get('/listarCliente', 'ClienteController@index');
    Route::get('/listarCliente/{id}', 'ClienteController@show');
    Route::put('/editarCliente/{id}', 'ClienteController@update');
    Route::delete('/excluirCliente/{id}', 'ClienteController@destroy');
    
    Route::get('/listarprodutos','ProdutosController@index');
    Route::get('listarprodutos/{id}','ProdutosController@show');
    Route::post('/cadastrarproduto', 'ProdutosController@create');
    Route::put('/editarproduto/{id}', 'ProdutosController@update');
    Route::delete('/excluirproduto/{id}', 'ProdutosController@destroy');
});
