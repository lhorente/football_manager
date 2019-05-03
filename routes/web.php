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
Route::get('/clubs', 'ClubsController@index')->name('clubsIndex'); // List all clubs
Route::get('/clubs/{id}/players', 'ClubsController@viewPlayers')->name('clubsViewPlayers'); // View club players
Route::get('/clubs/create', 'ClubsController@create')->name('clubsCreate'); // create club form
Route::get('/clubs/edit/{id}', 'ClubsController@edit')->name('clubsEdit'); // edit club form
Route::get('/clubs/remove/{id}', 'ClubsController@remove')->name('clubsRemove'); // Remove club
Route::post('/clubs/create', 'ClubsController@postCreate')->name('clubsPostCreate'); // Create club
Route::post('/clubs/edit/{id}', 'ClubsController@postEdit')->name('clubsPostEdit'); // Edit club

// Players
Route::get('/players', 'PlayersController@index')->name('playersIndex'); // List all players
Route::get('/players/{id}', 'PlayersController@view')->name('playersView'); // View player
Route::get('/players/create', 'PlayersController@create')->name('playersCreate'); // create player form
Route::get('/players/edit/{id}', 'PlayersController@edit')->name('playersEdit'); // edit player form
Route::get('/players/remove/{id}', 'PlayersController@remove')->name('playersRemove'); // Remove player
Route::post('/players/create', 'PlayersController@postCreate')->name('playersPostCreate'); // Create player
Route::post('/players/edit/{id}', 'PlayersController@postEdit')->name('playersPostEdit'); // Edit player

Route::get('/export', 'PlayersController@export')->name('playersExport'); // Export players
Route::post('/export', 'PlayersController@postExport')->name('playersPostExport'); // Export players to CSV