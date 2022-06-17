<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('trips', 'App\Http\Controllers\ApiController@trips');
Route::get('available-seats', 'App\Http\Controllers\ApiController@availableSeats');
Route::post('make-reservation', 'App\Http\Controllers\ApiController@makeReservation');

Route::get('cities', 'App\Http\Controllers\CityController@index');