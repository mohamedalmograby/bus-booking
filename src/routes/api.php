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




Route::post('register' , 'App\Http\Controllers\AuthController@register')->name('register'); ; 
Route::post('login' , 'App\Http\Controllers\AuthController@login')->name('login'); ; 


Route::middleware('auth:api')->group(function(){
    Route::post('available-seats', 'App\Http\Controllers\ApiController@availableSeats');
    Route::post('make-reservation', 'App\Http\Controllers\ApiController@makeReservation');
});
