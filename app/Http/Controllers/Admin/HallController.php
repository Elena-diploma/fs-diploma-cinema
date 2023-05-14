<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HallRequest;
use App\Models\Hall;
use App\Models\HallSize;
use App\Models\Movie;
use App\Models\MovieShow;
use App\Models\Place;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class HallController extends Controller
{
    /**
     *отображает залы
     *
     * @return mixed
     */
    public function index(): mixed
    {
        $halls = Hall::with('seances', 'seats')->join('hall_sizes', 'hall_sizes.id', '=', 'halls.id')->get();
        $movie = Movie::all();
        $movieShow = MovieShow::all();

        if (Auth::user()->is_admin !== '1') {
            return redirect('/index');
        }
        return view('admin.admin', ['seats' => $this->seats($halls), 'hallSeances' => $this->hallSeances($halls, $movie), 'hallIsActive' => $this->activeHall($halls, $movieShow)
        ], compact('halls'));
    }

    /**
     * новый зал
     *
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Сохраняет новый зал
     *
     * @param  HallRequest  $request
     * @return array
     */
    public function store(HallRequest $request): array
    {
        Hall::create($request->validated());
        $hall_id = Hall::where('name', $request->name)->first()->id;
        return ['hall_id' => $hall_id, 'hall_name' => $request->name];
    }

    /**
     * Находит нужный зал
     *
     * @param  int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        return Hall::findOrFail($id);
    }

    /**
     * Редактирует выбранный зал
     *
     * @param Hall $hall
     * @return void
     */
    public function edit(Hall $hall): void
    {
        //
    }

    /**
     * Обновляет изменения в зале
     *
     * @param HallRequest $request
     * @param Hall $hall
     * @return bool
     */
    public function update(HallRequest $request, Hall $hall): bool
    {
        $hall->fill($request->validated());
        return $hall->save();
    }

    /**
     * Удаляет зал
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Hall::find($request->hall_id)->delete();
        HallSize::find($request->hall_id)->delete();
        Place::where('hall_id', $request->hall_id)->delete();
        Price::where('hall_id', $request->hall_id)->delete();
    }

    /**
     * метод возвращает матрицу свободных билетов
     *
     * @param Request $request
     * @return string[]
     */

    public function setActive(Request $request): array
    {
        $hall = Hall::findOrFail($request->id);
        if ($hall->is_active) {
            $hall->is_active = false;
            $hall->save();
            return ['Открыть продажу билетов', 'Зал Готов к открытию'];
        } else {
            if (!Place::where('hall_id', $hall->id)->first()) {
                $hall->is_active = false;
                return ['Открыть продажу билетов', 'Установите конфигурацию зала'];
            }
            if (!Price::where('hall_id', $hall->id)->first()) {
                $hall->is_active = false;
                return ['Открыть продажу билетов', 'Установите конфигурацию цен в зале'];
            }
            $hall->is_active = true;
            $hall->save();
            return ['Закрыть продажу билетов', 'Продажа билетов окрыта'];
        }
    }

    /**
     * метод возвращает матрицу сеансов
     */
    public function hallSeances($halls, $movie): array
    {
        $arr = [];

        for ($i = 0; $i < $halls->count(); $i++) {
            for ($j = 0; $j < $halls[$i]->seances->count(); $j++) {
                $arr[$halls[$i]->id][$j] = [];
                try {
                    $d = (int)($movie->where('id', $halls[$i]->seances[$j]->movie_id)->first()->duration) / 2;
                    $st = (int)($halls[$i]->seances[$j]->start_time) * 30;
                    $mn = $movie->where('id', $halls[$i]->seances[$j]->movie_id)->first()->title;
                    $arr[$halls[$i]->id][$j][] = $d;
                    $arr[$halls[$i]->id][$j][] = $st;
                    $arr[$halls[$i]->id][$j][] = $mn;
                } catch (\Exception $e) {
                    $arr[] = null;
                }
            }
        }
        return $arr;
    }

    /**
     * метод возвращает матрицу билетов
     */
    public function seats($halls): array
    {
        $arr = [];
        foreach ($halls as $key => $value) {
            $hall = $halls->where('id', $value->id)->first();
            for ($i = 0; $i < $value->rows; $i++) {
                for ($j = 0; $j < $value->cols; $j++) {
                    $arr[$hall->name][$i][$j] = [];
                    try {
                        $seatStatus = $hall->seats->where('row_num', $i)->where('seat_num', $j)->first()->status;
                        $arr[$hall->name][$i][$j][] = $seatStatus;
                    } catch (\Exception $e) {
                        $arr[$hall->name][$i][$j][] = 'standart';
                    }
                }
            }
        }
        return $arr;
    }

    /**
     * метод возвращает матрицу залов
     */
    public function activeHall($halls, $movieShow): array
    {
        $arr = [];
        foreach ($halls as $key => $value) {
            $arr[$value->id] = [];
            if ($movieShow->where('hall_id', $value->id)->first()) {
                $arr[$value->id][] = 'is_active';
            } else {
                $arr[$value->id][] = null;
            }
        }
        return $arr;
    }
}
