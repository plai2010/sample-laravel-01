<?php

use Illuminate\Support\Facades\Route;

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

// Retrieve API token. Better mechanism (e.g. Passport or Sanctum)
// should be used for production.
Route::get('/api-token', function() {
    $user = Request::user();
    assert($user);
    return response()->json([
        'access_token' => $user->api_token ? [
            'type' => 'bearer',
            'token' => $user->api_token,
        ] : null,
    ]);
})->middleware('auth')->name('api-token.get');
