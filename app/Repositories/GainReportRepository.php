<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class GainReportRepository
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function gains($farmId, array $filters = [])
    {

        $gains =  DB::table("tabela1")
            ->fromRaw("(
                SELECT animals.farm_id, animals.id, animals.earring,
                (SELECT msub.movement_date FROM movements msub WHERE animals.id = msub.animal_id ORDER BY msub.movement_date ASC LIMIT 1) AS start_date,
                (SELECT msub.movement_date FROM movements msub WHERE animals.id = msub.animal_id ORDER BY msub.movement_date DESC LIMIT 1) AS final_date,
                (SELECT msub.movement_date FROM movements msub WHERE animals.id = msub.animal_id ORDER BY msub.weight DESC LIMIT 1) AS less_weight_date,
                (SELECT msub.weight FROM movements msub WHERE animals.id = msub.animal_id ORDER BY msub.movement_date ASC LIMIT 1) AS start_weight,
                (SELECT msub.weight FROM movements msub WHERE animals.id = msub.animal_id ORDER BY msub.movement_date DESC LIMIT 1) AS final_weight,
                (SELECT msub.weight FROM movements msub WHERE animals.id = msub.animal_id ORDER BY msub.weight ASC LIMIT 1) AS less_weight,
                animals.obs
                FROM animals
                JOIN movements ON animals.id=movements.animal_id
                JOIN collects ON collects.id = movements.collect_id
                WHERE movements.operation IN ('E', 'TE')) as tabela1")
            ->selectRaw("*, final_weight-start_weight AS gains_kg, DATEDIFF(final_date, start_date) AS difference_days,
            IFNULL(DATEDIFF(final_date, start_date)/(final_weight-start_weight),0) AS gains_day_kg,
            (IFNULL(DATEDIFF(final_date, start_date)/(final_weight-start_weight),0)*30) AS gains_month_kg,
            ((IFNULL(DATEDIFF(final_date, start_date)/(final_weight-start_weight),0)*30))*12 AS gains_year_kg
            ");

        // $gains->where('animals.farm_id', $farmId);

        if (isset($filters['range']) && count($filters['range']) != 2) {
            foreach ($filters['range'] as $filter) {
                if (!isset($filter['values']) || !is_array($filter['values'])) continue 1;

                if (!isset($filter['collumn']) || !is_string($filter['collumn'])) continue 1;

                if ($filter['collumn'] == 'difference_days') {
                    $gains->whereRaw("DATEDIFF(final_date, start_date)", $filter['values']);
                } else if ($filter['collumn'] == 'gains_kg') {
                    $gains->whereRaw("final_weight-start_weight", $filter['values']);
                } else if ($filter['collumn'] == 'gains_day_kg') {
                    $gains->whereRaw("IFNULL(DATEDIFF(final_date, start_date)/(final_weight-start_weight),0)", $filter['values']);
                } else if ($filter['collumn'] == 'gains_month_kg') {
                    $gains->whereRaw("(IFNULL(DATEDIFF(final_date, start_date)/(final_weight-start_weight),0)*30)", $filter['values']);
                } else if ($filter['collumn'] == 'gains_year_kg') {
                    $gains->whereRaw("((IFNULL(DATEDIFF(final_date, start_date)/(final_weight-start_weight),0)*30))*12", $filter['values']);
                } else  if (in_array($filter['collumn'], ['movement_date'])) {
                    $gains->where($filter['collumn'], '>=', $filter['values'][0]);
                    $gains->where($filter['collumn'], '<=',  $filter['values'][1]);
                } else if (in_array($filter['collumn'], ['gains_kg', 'gains_day_kg', 'gains_month_kg', 'gains_year_kg'])) {
                    $gains->where($filter['collumn'], '>=',  (float) $filter['values'][0]);
                    $gains->where($filter['collumn'], '<=',  (float) $filter['values'][1]);
                } else {
                    $gains->where($filter['collumn'], '>=',  $filter['values'][0]);
                    $gains->where($filter['collumn'], '<=',  $filter['values'][1]);
                }
            }
        }

        return $gains->get();
    }

    public function single($farmId, array $filters = [])
    {
        $single =  DB::table('movements')
            ->selectRaw('collects.name,  movements.collect_id,  movements.farm_id, movements.note, movements.movement_date, movements.weight, movements.price')
            ->join('collects', 'collects.id', '=', 'movements.collect_id')
            ->whereIn('movements.operation', ['S', 'TS'])
            ->where('movements.is_animal', '=', 0)
            ->where('movements.farm_id', '=', $farmId);

            if (isset($filters['range']) && count($filters['range']) != 2) {
                foreach ($filters['range'] as $filter) {
                    if (!isset($filter['values']) || !is_array($filter['values'])) continue 1;

                    if (!isset($filter['collumn']) || !is_string($filter['collumn'])) continue 1;

                    if (in_array($filter['collumn'], ['movement_date'])) {
                        $single->where($filter['collumn'], '>=', $filter['values'][0]);
                        $single->where($filter['collumn'], '<=', $filter['values'][1]);
                    }
                }
            }

        return  $single->get();
    }
}
