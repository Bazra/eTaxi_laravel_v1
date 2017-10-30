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

Route::resource('/v1/drivers', v1\DriverController::class, [
	'except' => ['create', 'edit']
]);

Route::resource('/v1/passengers', v1\PassengerController::class, [
	'except' => ['create', 'edit']
]);

Route::resource('/v1/taxi_bookings', v1\TaxiBookingController::class, [
	'except' => ['create', 'edit']
]);

Route::resource('/v1/taxi_fare_rates', v1\TaxiFareRateController::class, [
	'except' => ['create', 'edit', 'store', 'update']
]);

Route::post('v1/driver/login', 'v1\DriverController@login');
Route::post('v1/passenger/login', 'v1\PassengerController@login');
Route::post('v1/taxi_booking/history', 'v1\TaxiBookingController@history');
Route::post('v1/driver/free', 'v1\DriverController@freeDrivers');