<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHallSizeRequest;
use App\Models\HallSize;
use App\Http\Requests\HallSizeRequest;
use Illuminate\Http\Response;

class HallSizeController extends Controller
{
    /**
     * Показывает список залов
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return HallSize::all();
    }

    /**
     * Показать форму зала
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Сохраняет выбранное место в зале
     *
     * @param  HallSizeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HallSizeRequest $request)
    {
        HallSize::insertGetId($request->validated());
        return $request;
    }

    /**
     * Показывает выбранное место в зале
     *
     * @param  \App\Models\HallSize  $hallSize
     * @return \Illuminate\Http\Response
     */
    public function show(int $hall_id)
    {
        return HallSize::findOrFail($hall_id);
    }

    /**
     * Редактирует выбранное место в зале
     *
     * @param  \App\Models\HallSize  $hallSize
     * @return \Illuminate\Http\Response
     */
    public function edit(HallSize $hallSize)
    {
        //
    }

    /**
     * Обновляет места в зале
     *
     * @param  UpdateHallSizeRequest  $request
     * @param  \App\Models\HallSize  $hallSize
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHallSizeRequest $request, HallSize $hallSize)
    {
        $hallSize->fill($request->validated());
        return $hallSize->save();
    }

    /**
     * Удаляет места в зале
     *
     * @param  \App\Models\HallSize  $hallSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(HallSize $hallSize)
    {
        if ($hallSize->delete()) {
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return null;
    }
}

