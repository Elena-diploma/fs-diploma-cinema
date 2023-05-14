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
     * @return Response
     */
    public function index(): Response
    {
        return Movie::all();
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
     * Показывает форму для покупки
     *
     * @param MovieRequest $request
     * @return void
     */
    public function store(MovieRequest $request): void
    {
        Movie::create($request->validated());
    }

    /**
     * Показывает выбранный фильм
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        return Movie::findOrFail($id);
    }

    /**
     * форма редактирования фильма
     *
     * @param Movie $movie
     * @return void
     */
    public function edit(Movie $movie):void
    {
        //
    }

    /**
     * Обновление фильма
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Movie $movie
     * @return void
     */
    public function update(Request $request, Movie $movie): void
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
        $movie_id = Movie::where('title', $request->title)->first()->id;
        Movie::where('id', $movie_id)->first()->delete();
        MovieShow::where('movie_id', $movie_id)->delete();
    }
}
