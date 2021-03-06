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

Route::get('/test', function (Request $request){
    //dd($request->headers->get('')); chave get para pegar informação no cabeçalho

    $response =  new \Illuminate\Http\Response(json_encode(['msg'=>'Minha primeira resposta da api']));
    $response->header('Content-Type','application/json');
    return $response;
   //return ['msg'=>'Minha primeira resposta da api']; já retorna como application/json
});


Route::namespace('Api')->group(function (){


    // Product Route
    Route::prefix('products')->group(function (){
        Route::get('/','ProductController@index');
        Route::get('/{id}','ProductController@show');
        Route::post('/','ProductController@save')->middleware('auth.basic');
        Route::put('/','ProductController@update');
        Route::patch('/','ProductController@update');
        Route::delete('/{id}','ProductController@delete');
    });

    // User Route
    Route::resource('/users','UserController');
});
