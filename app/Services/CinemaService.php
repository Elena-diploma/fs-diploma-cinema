<?php

namespace App\Services;

use Carbon\Carbon;

class CinemaService
{

    private MovieService $movieService;
    private HallService $hallService;

    public function __construct(HallService $hallService, MovieService $movieService)
    {
        $this->hallService = $hallService;
        $this->movieService = $movieService;
    }

    /**
     * @return HallService
     */
    public function getHallService(): HallService
    {
        return $this->hallService;
    }

    /**
     * @return MovieService
     */
    public function getMovieService(): MovieService
    {
        return $this->movieService;
    }

    /**
     * формирует фильмы по кинозалам
     */
    public function movieShow(): array
    {
        $halls = $this->hallService->getActiveHallsWithSeances();
        $movies = $this->movieService->getAll();
        $arr = [];
        for($i = 0; $i < $movies->count(); $i++) {
            for($j = 0, $jMax = count($halls); $j < $jMax; $j++) {
                $arr[$i][$j] = [];
                try {
                    $hallId = $halls[$j]->seances->where('movie_id', $movies[$i]->id)->first()->hall_id;
                    $hallName = $halls->where('id', $hallId)->first()->name;
                    $isActive = $halls->where('id', $hallId)->first()->is_active;
                    if($isActive) {
                        $arr[$i][$j][] = $hallName;
                    } else {
                        $arr[$i][$j][] = null;
                    }
                } catch (\Exception $e) {
                    $arr[$i][$j][] = null;
                }
            }
        }
        return $arr;
    }

    /**
     * переводит на русский язык дни недели
     */
    public function getWeekDayRus(): array
    {
        $days = array(
            'Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'
        );

        $arr = [];
        for($i = 0; $i < 7; $i++) {
            $date = Carbon::now();
            $arr[$i] = [];
            $date->addDays($i);
            $myDay = $date->format('w');
            $weekEnd = (($myDay == 0) || ($myDay == 6)) ? 'page-nav__day_weekend' : '';
            $timeStamp = $date->getTimeStamp();

            $result = array('day' => $date->format('j'),
                'dayWeek' => $days[$myDay],
                'weekEnd' => $weekEnd,
                'timeStamp' => $timeStamp);
            $arr[$i][] = $result;
        }
        return $arr;
    }
}
