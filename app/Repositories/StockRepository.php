<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class StockRepository {

    public function advanced()
    {
        $query = "farm_id, farms.name,
        SUM(CASE WHEN weight BETWEEN 0 AND 179.99 THEN 1 ELSE 0 END)  AS PESO1,
        SUM(CASE WHEN weight BETWEEN 180 AND 239.99 THEN 1 ELSE 0 END) AS PESO2,
        SUM(CASE WHEN weight BETWEEN 240 AND 299.99 THEN 1 ELSE 0 END) AS PESO3,
        SUM(CASE WHEN weight BETWEEN 300 AND 359.99 THEN 1 ELSE 0 END) AS PESO4,
        SUM(CASE WHEN weight BETWEEN 360 AND 419.99 THEN 1 ELSE 0 END) AS PESO5,
        SUM(CASE WHEN weight BETWEEN 420 AND 479.99 THEN 1 ELSE 0 END) AS PESO6,
        SUM(CASE WHEN weight BETWEEN 480 AND 539.99 THEN 1 ELSE 0 END) AS PESO7,
        SUM(CASE WHEN weight >= 540 THEN 1 ELSE 0 END) AS PESO8";

        return DB::table('animals')->selectRaw($query)
        ->join('farms', 'animals.farm_id', '=', 'farms.id')
        ->groupBy('farm_id')
        ->get();
    }

}
