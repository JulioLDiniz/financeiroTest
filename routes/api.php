<?php
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
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
Route::get('/lancamento/{id}','LancamentoController@listOne');
Route::get('/lancamentos','LancamentoController@listAll');
Route::put('/update-lancamento/{id}','LancamentoController@update');
Route::delete('/delete-lancamento/{id}','LancamentoController@delete');
Route::put('/baixa-lancamento/{id}','LancamentoController@giveLowLancamento');

