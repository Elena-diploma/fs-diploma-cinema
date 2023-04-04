<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Price;
use App\Models\TakenPlace;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TakenPlaceController extends Controller
{
    /**
     * Показывает список занятых мест
     *
     * @return Response
     */
    public function index()
    {
        return TakenPlace::all();
    }

    /**
     * Показывает форму для выбора места
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Показывает занятые места
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Показывает занятые места
     *
     * @param  \App\Models\TakenPlace  $takenPlace
     * @return Response
     */
    public function show(TakenPlace $takenPlace)
    {
        //
    }

    /**
     * редактирование занятого места
     *
     * @param  \App\Models\TakenPlace  $takenPlace
     * @return Response
     */
    public function edit(TakenPlace $takenPlace)
    {
        //
    }

    /**
     * Обновление занятых места
     *
     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Models\TakenPlace  $takenPlace
     * @return Response
     */
    public function update(Request $request)
    {
        $hall_id = Hall::where('name', $request->hallName)->first()->id;

        $placesArray = [];
        $totalPrice = 0;
        $standartPrice = Price::where('hall_id', $hall_id)->where('status', 'standart')->first()->price;
        $standartVip = Price::where('hall_id', $hall_id)->where('status', 'vip')->first()->price;
        for ($i = 0, $iMax = count($request->takenPlaces); $i < $iMax; $i++) {
            $row = (string)$request->takenPlaces[$i]['row'];
            $place = (string)$request->takenPlaces[$i]['place'];
            $status = $request->takenPlaces[$i]['type'];
            if ($status === 'standart') {
                $price = $standartPrice;
            }
            if ($status === 'vip') {
                $price = $standartVip;
            }
            $str = $row . '/' . $place;
            array_push($placesArray, $str);
            $totalPrice += $price;
        }
        $takenPlacesStr = join(', ', $placesArray);

        return route('payment', ['movie_title' => $request->movie, 'start_time' => $request->seance, 'hall_name' => $request->hallName, 'takenPlaces' => $takenPlacesStr, 'total_price' => $totalPrice, 'takenPlacesArr' => $request->takenPlaces]);

    }

    /**
     * Удаление занятого места
     *
     * @param  \App\Models\TakenPlace  $takenPlace
     * @return Response
     */
    public function destroy(TakenPlace $takenPlace)
    {
        //
    }
}
