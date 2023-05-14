<?php

namespace App\Services;

use App\Models\Hall;

class HallService
{
    /**
     * @return mixed
     */
    public function getActiveHalls(): mixed
    {
        return Hall::where('is_active', Hall::$ACTIVE)
            ->join('prices', 'prices.hall_id', '=', 'halls.id')
            ->join('hall_sizes', 'hall_sizes.id', '=', 'halls.id')
            ->select('halls.*', 'prices.status', 'prices.price', 'hall_sizes.rows', 'hall_sizes.cols')
            ->with('seats', 'takenSeat')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getActiveHallsWithSeances(): mixed
    {
        return Hall::where('is_active', Hall::$ACTIVE)->with('seances')->get();
    }

    public function getHallByName(String $hallName): mixed
    {
        return $this->getActiveHalls()->where('name', $hallName)->first();
    }

    public function getHallMetric(int $hallId, String $metricName): mixed
    {
        return match ($metricName) {
            'rows' => $this->getActiveHalls()->where('id', $hallId)->first()->rows,
            'cols' => $this->getActiveHalls()->where('id', $hallId)->first()->cols,
        };
    }

    /**
     * метод возвращает матрицу залов
     */
    public function seats($start_time, $movie): array
    {
        $halls = $this->getActiveHalls();
        $arr = [];
        foreach ($halls as $key => $value) {
            $hall = $halls->where('id', $value->id)->first();
            for ($i = 0; $i < $value->rows; $i++) {
                for ($j = 0; $j < $value->cols; $j++) {
                    $arr[$value->id][$i][$j] = [];
                    try {
                        $seance_id = $movie->where('hall_id', $value->id)->where('start_time', $start_time)->first()->id;
                        $s = $hall->seats->where('row_num', $i)->where('seat_num', $j)->first()->status;
                        if ($hall->takenSeat->where('hall_id', $hall['id'])->where('seance_id', $seance_id)->where('row_num', $i)->where('seat_num', $j)->first()->taken) {
                            $s = 'taken';
                        }
                        $arr[$value->id][$i][$j][] = $s;
                    } catch (\Exception $e) {
                        $arr[$value->id][$i][$j][] = 'standart';
                    }
                }
            }
        }
        return $arr;
    }
}
