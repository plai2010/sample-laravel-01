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

Route::middleware('auth')->group(function() {
    Route::get('/employees', 'EmployeeController@index')
        ->name('employees.index');
    Route::get('/employees/{employee}', 'EmployeeController@show')
        ->name('employees.show');

    // Requests for admin users only.
    Route::middleware('auth:admin')->group(function() {
        Route::get('/employees/create', 'EmployeeController@create')
            ->name('employees.create');
        Route::get('/employees/{employee}/edit', 'EmployeeController@edit')
            ->name('employees.edit');
        Route::post('/employees', 'EmployeeController@store')
            ->name('employees.store');
        Route::put('/employees/{employee}', 'EmployeeController@update')
            ->name('employees.update');
        Route::delete('/employees/{employee}', 'EmployeeController@destroy')
            ->name('employees.destroy');

        Route::get('/employees/admin', 'EmployeeController@admin')
            ->name('employees.admin');
        Route::get('/employees/admin/{employee}','EmployeeController@adminShow')
            ->name('employees.admin.show');
        Route::get('/employees/admin/spa', function() {
            $user = Request::user();
            assert($user->admin ?? false);
            return view('employees.admin.spa', [
                'token_url' => route('api-token.get'),
            ]);
        })->name('employees.admin-spa');
    });
});

// vim: set ts=4 expandtab syntax=php:
