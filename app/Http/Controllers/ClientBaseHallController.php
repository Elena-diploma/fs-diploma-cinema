<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\MovieShow;
use App\Services\HallService;
use App\Http\Controllers\Base\BaseHallController;

class ClientBaseHallController extends BaseHallController
{
    /**
     * метод возвращает view client.hall
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $halls = $this->cinemaService->getHallService()->getActiveHalls();
        $hall_name = $_GET['hall_name'];
        $hall = $this->cinemaService->getHallService()->getHallByName($hall_name);
        $movie_title = $_GET['movie'];
        $start_time = $_GET['start_time'];
        $movie = MovieShow::all();

        $rows = $this->cinemaService->getHallService()->getHallMetric($hall->id, 'rows');
        $cols = $this->cinemaService->getHallService()->getHallMetric($hall->id, 'cols');
        $seats = $this->cinemaService->getHallService()->seats($start_time, $movie);

        return view('client.hall', [
            'hall_name' => $hall_name,
            'hall' => $hall,
            'movie_title' => $movie_title,
            'start_time' => $start_time,
            'seats' => $seats,
            'rows' => $rows,
            'cols' => $cols
        ], compact('halls'));
    }
}
