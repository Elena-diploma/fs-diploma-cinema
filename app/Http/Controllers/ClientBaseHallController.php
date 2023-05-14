<?php

namespace App\Http\Controllers;

use App\Models\MovieShow;
use App\Http\Controllers\Base\BaseHallController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ClientBaseHallController extends BaseHallController
{
    /**
     * метод возвращает view client.hall
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
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
