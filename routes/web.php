<?php

use App\Http\Controllers\Admin\HallController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\ClientBaseHallController;
use App\Http\Controllers\ClientIndexControllerBase;
use App\Http\Controllers\ClientPaymentController;
use App\Http\Controllers\ClientTicketController;
use App\Http\Controllers\HallSizeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieShowController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\TakenPlaceController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

Route::get('/', [ClientIndexControllerBase::class, 'index'])->name('index');
Route::get('/hall', [ClientBaseHallController::class, 'index'])->name('client_hall');
Route::get('/client-hall', [TakenPlaceController::class, 'update']);
Route::get('/payment', [ClientPaymentController::class, 'index'])->name('payment');
Route::get('/ticket', [ClientTicketController::class, 'index'])->name('ticket');

Auth::routes();

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/admin', [HallController::class, 'index'])->name('admin');
    Route::post('/delete-hall', [HallController::class, 'destroy'])->name('delete_hall');
    Route::post('/hall-add', [HallController::class, 'store']);
    Route::post('/hall-size', [HallSizeController::class, 'store'])->name('hall_size');
    Route::post('/admin/hall-chair-create/{result}', [PlaceController::class, 'store']);
    Route::post('/hall-chair', [PlaceController::class, 'update'])->name('hall_chair');
    Route::get('/admin/hall-chair-delete/{id}', [PlaceController::class, 'destroy'])->name('hall_chair_delete');

    Route::get('/show-price', [PriceController::class, 'show']);
    Route::post('/save-price', [PriceController::class, 'update']);

    Route::post('/add-movie', [MovieController::class, 'store'])->name('Movie_add');
    Route::post('delete-movie', [MovieController::class, 'destroy'])->name('Movie_delete');

    Route::post('/add-movie-show', [MovieShowController::class, 'store'])->name('add_movie_show');
    Route::post('/delete-movie-show', [MovieShowController::class, 'destroy'])->name('delete_movie_show');
    Route::post('/start-of-sales', [HallController::class, 'setActive'])->name('start_of_sales');
});
