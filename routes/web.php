<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'cliente'], function(){
    Route::get('/criar', function () {
        return view('cliente.criar');
    });

    Route::get('/acao', function () {
        return view('cliente.acao');
    });
});

Route::group(['prefix'=>'vendas'],function(){
    Route::get('/criar', function () {
        return view('vendas.criar');
    });
    Route::get('/acao',function(){
        return view('vendas.acao');
    });
});
Route::group(['prefix'=>'produto'], function(){
    Route::get('/criar', function () {
        return view('produto.criar');
    });

    Route::get('/acao', function () {
        return view('produto.acao');
    });
});
