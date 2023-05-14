<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieShowRequest;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\MovieShow;
use App\Models\Place;
use App\Models\TakenPlace;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MovieShowController extends Controller
{
    /**
     * Показывает список фильмов
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return MovieShow::all();
    }

    /**
     * Показывает форму для выбора фильмов
     *
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Показывает список фильмов
     *
     * @param Request $request
     * @return string|void
     */
    public function store(MovieShowRequest $request)
    {
        $id = Movie::where('title', $request->movie_name)->first()->id;
        $all = MovieShow::all();

        $arr = [];
        foreach ($all as $key => $value) {
            if ($value->hall_id == $request->hall_id) {
                $dur = Movie::where('id', $value->movie_id)->first()->duration;
                $m = floor((strtotime($value->start_time)-strtotime($request->start_time))/60);
                if (abs($m)< $dur) {
                    array_push($arr, abs($m));
                }
            }
        }

        if (count($arr) === 0) {
            if (!MovieShow::where('hall_id', $request->hall_id)->where('start_time', $request->start_time)->first()) {
                MovieShow::create([
                    'hall_id' => $request->hall_id,
                    'movie_id' => $id,
                    'start_time' => $request->start_time
                ]);
            }
            $seance_id = MovieShow::where('hall_id', $request->hall_id)->where('start_time', $request->start_time)->first()->id;
            $seats = Place::where('hall_id', $request->hall_id)->get();
            foreach ($seats as $key => $value) {
                TakenPlace::create([
                    'hall_id' => $request->hall_id,
                    'seance_id' => $seance_id,
                    'row_num' => $value['row_num'],
                    'seat_num' => $value['seat_num'],
                    'taken' => false
                ]);
            }
        } else {
            return 'Время сеанса уже занято! Выберите другое время!';
        }
    }

    /**
     * Показывает выбранный фильм
     *
     * @param Request $request
     * @return Request
     */
    public function show(Request $request)
    {
        return $request;
    }

    /**
     * редактирование выбранного фильма
     *
     * @param MovieShow $movieShow
     * @return void
     */
    public function edit(MovieShow $movieShow): void
    {
        //
    }

    /**
     * Обновление выбранного фильма
     *
     * @param Request $request
     * @param MovieShow $movieShow
     * @return void
     */
    public function update(Request $request, MovieShow $movieShow): void
    {
        //
    }

    /**
     * Удаление выбранного фильма
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $movie_id = Movie::where('title', $request->movieName)->first()->id;
        MovieShow::where('hall_id', $request->hall_id)->where('movie_id', $movie_id)->where('start_time', $request->movieTime)->first()->delete();
        if (!MovieShow::find($request->hall_id)) {
            $hall = Hall::where('id', $request->hall_id)->first();
            $hall->is_active = 0;
            $hall->save();
        }
    }
}
