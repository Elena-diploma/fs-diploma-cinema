<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    /**
     * Создает новую авторизацию
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Показывает панель
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
