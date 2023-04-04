<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieShow;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    /**
     * Показывает список фильмов
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Movie::all();
    }

    /**
     * Показывает форму для выбора фильмов
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Показывает форму для покупки
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request)
    {
        Movie::create($request->validated());
    }

    /**
     * Показывает выбранный фильм
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        return Movie::findOrFail($id);
    }

    /**
     * форма редактирования фильма
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Обновление фильма
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Удаление выбранного фильма
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $movie_id = Movie::where('title', $request->title)->first()->id;
        Movie::where('id', $movie_id)->first()->delete();
        MovieShow::where('movie_id', $movie_id)->delete();
    }
}
