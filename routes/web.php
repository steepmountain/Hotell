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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('reservation')->group(function () {
    Route::get('create', 'ReservationController@create');
    Route::post('createReservation', 'ReservationController@createReservation');

    Route::get('search', 'ReservationController@search');
    Route::post('performSearch', 'ReservationController@performSearch');
});
