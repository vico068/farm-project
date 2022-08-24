<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Collect;
use App\Models\Movement;
use Illuminate\Support\Facades\DB;

class MapaRepository
{
    protected Collect $collect;
    protected Movement $movement;

    public function __construct(Collect $collect, Movement $movement)
    {
        $this->collect = $collect;
        $this->movement = $movement;
    }


    public function mapa($farmId, string $startDate  = null, string $endDate = null)
    {

        $collects = $this->movement->select('collects.name', 'movements.operation', 'collects.movement_date', DB::raw('COUNT(movements.id)   AS total'))
            ->join('collects', 'collects.id', '=', 'movements.collect_id')
            ->where('movements.farm_id', $farmId)
            ->orderBy('movements.movement_date', 'asc')
            ->orderBy('movements.id', 'asc')
            ->groupBy('movements.collect_id');

        if ($startDate) {
            $collects->whereDate('movement_date', '>=', $startDate);
        }

        if ($endDate) {
            $collects->whereDate('movement_date', '<=', $endDate);
        }

        $collects = $collects->get();

        return $collects;
    }
}
