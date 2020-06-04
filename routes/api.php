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
Route::post('/cadastrarCliente','Api\ClienteController@create');
Route::get('/listarCliente','Api\ClienteController@index');
Route::put('/alterarCliente/{id}','Api\ClienteController@update');
Route::delete('/excluirCliente/{id}','Api\ClienteController@destroy');
