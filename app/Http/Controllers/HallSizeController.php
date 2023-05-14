<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHallSizeRequest;
use App\Models\HallSize;
use App\Http\Requests\HallSizeRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class HallSizeController extends Controller
{
    /**
     * Показывает список залов
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return HallSize::all();
    }

    /**
     * Показать форму зала
     *
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Сохраняет выбранное место в зале
     *
     * @param HallSizeRequest $request
     * @return Response|HallSizeRequest
     */
    public function store(HallSizeRequest $request): Response|HallSizeRequest
    {
        HallSize::insertGetId($request->validated());
        return $request;
    }

    /**
     * Показывает выбранное место в зале
     *
     * @param int $hall_id
     * @return Response
     */
    public function show(int $hall_id): Response
    {
        return HallSize::findOrFail($hall_id);
    }

    /**
     * Редактирует выбранное место в зале
     *
     * @param HallSize $hallSize
     * @return void
     */
    public function edit(HallSize $hallSize): void
    {
        //
    }

    /**
     * Обновляет места в зале
     *
     * @param  UpdateHallSizeRequest  $request
     * @param HallSize $hallSize
     * @return bool
     */
    public function update(UpdateHallSizeRequest $request, HallSize $hallSize): bool
    {
        $hallSize->fill($request->validated());
        return $hallSize->save();
    }

    /**
     * Удаляет места в зале
     *
     * @param HallSize $hallSize
     * @return Response|null
     */
    public function destroy(HallSize $hallSize): ?Response
    {
        if ($hallSize->delete()) {
            return response(null, ResponseAlias::HTTP_NO_CONTENT);
        }
        return null;
    }
}

