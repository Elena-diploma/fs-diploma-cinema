<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PriceController extends Controller
{
    /**
     * Показывает цены на места в зале
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Price::all();
    }

    /**
     * Показывает форму для покупки билета
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Показывает цены на место
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
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
     * @return \Illuminate\Http\Response
     */
    public function show(Request  $request)
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Обновление выбранного места
     *
     * @param PriceRequest $request
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        foreach ($request->result as $key) {
            $seat = Price::where('hall_id', $key['hall_id'])->where('status', $key['status'])->first();
            if ($seat === null) {
                return $this->store($request);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $hall_id)
    {
        if (Price::where('hall_id', '=', $hall_id)->delete()) {
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return null;
    }
}
