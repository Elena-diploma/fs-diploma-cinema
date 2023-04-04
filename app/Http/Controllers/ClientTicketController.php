<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\MovieShow;
use App\Models\TakenPlace;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ClientTicketController extends Controller
{
    /**
     * возвращает view билетов пользователя
     */
    public function index()
    {
        $hall_name = $_GET['hall_name'];
        $movie_title = $_GET['movie_title'];
        $start_time = $_GET['start_time'];
        $places = $_GET['places'];
        $takenPlaces = $_GET['taken_places'];
        $QRtext = 'Фильм: ' . $movie_title . PHP_EOL . 'Зал: ' . $hall_name . PHP_EOL . 'Ряд/Место: ' . $places . PHP_EOL . PHP_EOL . 'Начало сеанса: ' . $start_time;
        $qr = QrCode::encoding('UTF-8')->size(200)->generate($QRtext);
        $takenSeats = TakenPlace::all();

        $this->hallUpdate($hall_name, $start_time, $takenPlaces, $takenSeats);

        return view('client.ticket', [
            'hall_name' => $hall_name,
            'movie_title' => $movie_title,
            'start_time' => $start_time,
            'places' => $places,
            'qr' => $qr,
        ]);
    }

    public function hallUpdate($hallName, $seance, $takenPlaces, $takenSeats) {
        $hall_id = Hall::where('name', $hallName)->first()->id;
        $seance_id = MovieShow::where('hall_id', $hall_id)->where('start_time', $seance)->first()->id;

        foreach ($takenPlaces as $key) {
            $seat = $takenSeats->where('hall_id', $hall_id)->where('seance_id', $seance_id)->where('row_num', $key['row'] - 1)->where('seat_num', $key['place'] - 1)->first();
            $seat->taken = 1;
            $seat->save();
        }
    }
}
