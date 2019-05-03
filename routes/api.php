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

Route::get('customers/requestCustomerAccessToken', 'Api\CustomersController@requestCustomerAccessToken');

// Clubs
Route::middleware('customer')->get('/clubs', 'Api\ClubsController@index'); // List all clubs
Route::middleware('customer')->get('/clubs/{id}', 'Api\ClubsController@get')->name('clubsGet'); // Return one club by ID
Route::middleware('customer')->post('/clubs', 'Api\ClubsController@create')->name('clubsPost'); // Create a new club
Route::middleware('customer')->post('/clubs/{id}', 'Api\ClubsController@edit')->name('clubsPut'); // Edit a club by ID
Route::middleware('customer')->delete('/clubs/{id}', 'Api\ClubsController@remove')->name('clubsDelete'); // Delete a club by ID

// Players
Route::middleware('customer')->get('/players', 'Api\PlayersController@index'); // List all players
Route::middleware('customer')->get('/players/{id}', 'Api\PlayersController@get'); // Return one player by ID
Route::middleware('customer')->post('/players', 'Api\PlayersController@create'); // Create a new player
Route::middleware('customer')->post('/players/{id}', 'Api\PlayersController@edit'); // Edit a player by ID
Route::middleware('customer')->delete('/players/{id}', 'Api\PlayersController@remove'); // Delete a player by ID