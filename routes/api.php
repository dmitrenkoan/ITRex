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
Route::group(['middleware' => ['api', 'auth:api']], function () {

Route::get('/user', function (Request $request) {
    return $request->user();
});
Route::get('publications', 'PublicationController@index');

Route::get('publications/{id}', 'PublicationController@show');

Route::post('publications', 'PublicationController@create');

Route::put('publications/{id}', 'PublicationController@update');

Route::delete('publications/{id}', 'PublicationController@delete');

});

Route::post('register', 'Auth\RegisterController@register');
