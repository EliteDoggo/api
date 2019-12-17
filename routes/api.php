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

Route::post('/signup', 'Auth@signup');

Route::post('/login', 'Auth@login');

Route::post('/logout', 'Auth@logout')->middleware('apiAuth');

Route::get('/user','Auth@user')->middleware('apiAuth');

Route::post('/photo', 'PhotoController@store');

Route::get('/photo/{id}','PhotoController@show');