<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Services\CinemaService;

class BaseHallController extends Controller
{
    protected CinemaService $cinemaService;

    /**
     * @param CinemaService $cinemaService
     */
    public function __construct(CinemaService $cinemaService)
    {
        $this->cinemaService = $cinemaService;
    }


}
