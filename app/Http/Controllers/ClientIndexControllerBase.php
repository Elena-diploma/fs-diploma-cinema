<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseHallController;

class ClientIndexControllerBase extends BaseHallController
{
    /**
     *основной метод получения заполненных залов и фильмов
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
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
