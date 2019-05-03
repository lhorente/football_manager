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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Clubs
Route::get('/clubs', 'ClubsController@index')->name('clubsIndex'); // Lista todos os clubes
Route::get('/clubs/{id}', 'ClubsController@index')->name('clubsGet'); // Exibe as informações de um clube
Route::post('/clubs', 'ClubsController@save')->name('clubsPost');
Route::put('/clubs/{id}', 'ClubsController@edit')->name('clubsPut');
Route::delete('/clubs/{id}', 'ClubsController@remove')->name('clubsDelete');
