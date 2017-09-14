<?php

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

Route::get('/login', 'Auth\LoginController@login')->name('login');

Route::get('/auth/redirect', 'Auth\LoginController@redirect')->name('auth.redirect');
Route::get('/auth/callback', 'Auth\LoginController@handle')->name('auth.callback');

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});
