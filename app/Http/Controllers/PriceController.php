<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Models\Price;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PriceController extends Controller
{
    /**
     * Показывает цены на места в зале
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Price::all();
    }

    /**
     * Показывает форму для покупки билета
     *
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Показывает цены на место
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $hall_id = $request->result[0]['hall_id'];
        foreach ($request->result as $key) {
            Price::create([
                'hall_id' => $key['hall_id'],
                'status' => $key['status'],
                'price' => $key['price']
            ]);
        }
    }

    /**
     * Показывает цену на выбранное место
     *
     * @param int $hall_id
     * @return Response
     */
    public function show(Request  $request): Response
    {
        $data = Price::where('hall_id', $request->hall_id)->get();
        if (!count($data)) {
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return $data;
    }

    /**
     * редактирование выбранного места
     *
     * @param  \App\Models\Price  $price
     * @return void
     */
    public function edit(Price $price): void
    {
        //
    }

    /**
     * Обновление выбранного места
     *
     * @param PriceRequest $request
     * @return void
     */
    public function update(Request $request): void
    {
        foreach ($request->result as $key) {
            $seat = Price::where('hall_id', $key['hall_id'])->where('status', $key['status'])->first();
            if ($seat === null) {
                $this->store($request);
            }

            if ($key['price'] !== null) {
                $seat->price = $key['price'];
            }
            $seat->save();
        }
    }

    /**
     * Удаление выбранного места
     *
     * @param  int $hall_id
     * @return Response
     */
    public function destroy(int $hall_id): Response
    {
        if (Price::where('hall_id', '=', $hall_id)->delete()) {
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return new Response();
    }
}
