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

Route::middleware('auth:api')->group(function () {
    Route::get('/tweets/home', 'TwitApiController@home');
    Route::get('/tweets/users/{id}', 'TwitApiController@userTweets');
    Route::get('/followers', 'TwitApiController@followers');
});
