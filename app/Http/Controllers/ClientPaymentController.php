<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ClientPaymentController extends Controller
{
    /**
     *возвращает view оплаты
     */
    public function index(): Factory|View|Application
    {
        $halls = Hall::all();
        $hall_name = $_GET['hall_name'];
        $hall = $halls->where('name', $hall_name)->first();
        $movie_title = $_GET['movie_title'];
        $start_time = $_GET['start_time'];
        $places = $_GET['takenPlaces'];
        $price = $_GET['total_price'];
        $taken_places = $_GET['takenPlacesArr'];

        return view('client.payment', [
            'hall_name' => $hall_name,
            'hall' => $hall,
            'movie_title' => $movie_title,
            'start_time' => $start_time,
            'places' => $places,
            'price' => $price,
            'taken_places' => $taken_places
        ]);
    }
}
