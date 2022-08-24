<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Infrastructure\ApiResponse;
use App\Models\Collect;
use App\Models\Movement;
use App\Models\MovementType;
use App\Repositories\CollectRepository;
use App\Repositories\Interfaces\CollectRepositoryInterface;
use App\Repositories\MapaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapaController extends Controller
{
    use ApiResponse;
    private MapaRepository $mapaRepository;

    public function __construct(MapaRepository $mapaRepository)
    {
        $this->mapaRepository = $mapaRepository;
    }

    public function index($farmId, Request $request)
    {
        try {
            $startDate = $request->startDate ?? null;
            $endDate = $request->endDate ?? null;

            $collects = $this->mapaRepository->mapa($farmId, $startDate, $endDate);

            foreach ($collects as $key => $value) {
                if ($key > 0) {
                    $before = $collects[$key - 1];
                    $total = $value->total_sum ?? $value->total;

                    if (MovementType::isTypeEntry($value->operation)) {
                        $value->total_sum =  $total + $before->total_sum;
                    }

                    if (MovementType::isTypeExit($value->operation)) {
                        $value->total_sum =  $before->total_sum - $total;
                    }
                } else {
                    if (MovementType::isTypeEntry($value->operation)) {
                        $value->total_sum = $value->total;
                    }

                    if (MovementType::isTypeExit($value->operation)) {
                        $value->total_sum = -$value->total;
                    }
                }
            }

            return $this->success('', $collects);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
