<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\HallSize;
use App\Models\Place;
use App\Models\TakenPlace;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceController extends Controller
{
    /**
     * Показывает список мест
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Place::all();
    }

    /**
     * Показывает форму для выбора места
     *
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Показывает наличие мест
     *
     * @param $result
     * @return RedirectResponse
     */
    public function store($result): RedirectResponse
    {
        $hall_id = $result[0]['hall_id'];
        Place::where('hall_id', $hall_id)->delete();

        foreach ($result as $key => $value) {
            Place::create([
                'hall_id' => $value['hall_id'],
                'row_num' => $value['row_num'],
                'seat_num' => $value['seat_num'],
                'status' => $value['status']
            ]);
        }
        return redirect()->route('admin');
    }

    /**
     * Показывает выбранное место
     *
     * @param  int $hall_id
     * @return Response
     */
    public function show(int $hall_id): Response
    {
        return Place::where('hall_id', '=', $hall_id)->get();
    }

    /**
     * редактирование выбранного места
     *
     * @param Place $place
     * @return Response
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Обновление выбранного места
     *
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function update(Request $request): Response|RedirectResponse
    {
        if ($request->hallSize['rows'] !== 0 && $request->hallSize['rows'] !== 0) {
            $hall = HallSize::where('id', $request->result[0]['hall_id'])->first();
            $hall->rows = $request->hallSize['rows'];
            $hall->cols = $request->hallSize['cols'];
            $hall->save();

            $h = Hall::where('id', $request->result[0]['hall_id'])->first();
            TakenPlace::where('hall_id', $hall->id)->delete();
            for ($s = 0; $s < $h->seances->count(); $s++) {
                for ($r = 0; $r < (int)$request->hallSize['rows']; $r++) {
                    for ($c = 0; $c < (int)$request->hallSize['cols']; $c++) {
                        TakenPlace::create([
                            'hall_id' => $hall->id,
                            'seance_id' => $s + 1,
                            'row_num' => $r,
                            'seat_num' => $c,
                            'taken' => false,
                        ]);
                    }
                }
            }
        }

        foreach ($request->result as $key => $value) {
            $seat = Place::where('hall_id', $value['hall_id'])->where('row_num', $value['row_num'])->where('seat_num', $value['seat_num'])->first();
            if ($seat === null) {
                return $this->store($request->result);
            } else {
                $seat->status = $value['status'];
                $seat->save();
            }
        }
        return $request->hallSize;
    }

    /**
     * Удаление выбранного места
     *
     * @param $id
     * @return RedirectResponse|null
     */
    public function destroy($id): ?RedirectResponse
    {
        if (Place::where('hall_id', $id)->delete()) {
            return redirect()->route('admin');
        }
        return null;
    }
}
