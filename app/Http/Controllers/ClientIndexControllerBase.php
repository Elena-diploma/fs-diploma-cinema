<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseHallController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ClientIndexControllerBase extends BaseHallController
{
    /**
     *основной метод получения заполненных залов и фильмов
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $halls = $this->cinemaService->getHallService()->getActiveHallsWithSeances();
        return view(
            'client.index',
            [
            'hallsShow' => $this->cinemaService->movieShow(),
            'weekDayRus' => $this->cinemaService->getWeekDayRus()
            ],
            compact('halls')
        );
    }
}
