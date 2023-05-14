<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Support\Renderable;

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
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('home');
    }
}
