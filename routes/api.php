<?php

use Illuminate\Http\Request;

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

//Endpoints para tags
Route::post('/create-tag', 'TagController@create');
Route::put('/update-tag/{id}','TagController@update');
Route::delete('/delete-tag/{id}','TagController@delete');
Route::get('/tag/{id}','TagController@listOne');
Route::get('/tags','TagController@listAll');


//Endpoints para lançamentos

Route::post('/create-lancamento','LancamentoController@create');

Route::post('/bind-tags/{idLancamento}','LancamentoController@bindTags');