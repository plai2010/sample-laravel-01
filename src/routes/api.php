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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function() {
	Route::get('/employees', 'EmployeeController@index');
	Route::get('/employees/{employee}', 'EmployeeController@show');

    // APIs for admin users only.
    Route::middleware('auth:admin')->group(function() {
	    Route::post('/employees', 'EmployeeController@store');
	    Route::put('/employees/{employee}', 'EmployeeController@update');
	    Route::delete('/employees/{employee}','EmployeeController@destroy');
    });
});

// vim: set ts=4 expandtab syntax=php:
