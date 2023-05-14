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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/hall', \App\Http\Controllers\Admin\HallController::class);

    Route::post('/hall/{id}/active/{is_active}', [\App\Http\Controllers\Admin\HallController::class, 'setActive']);

    Route::apiResource('hall-size', \App\Http\Controllers\HallSizeController::class);

    Route::apiResource('place', \App\Http\Controllers\Admin\PlaceController::class);

    Route::apiResource('/price', \App\Http\Controllers\PriceController::class);

    Route::apiResource('/movie', \App\Http\Controllers\MovieController::class);

    Route::apiResource('/movie-show', \App\Http\Controllers\MovieShowController::class);
});
