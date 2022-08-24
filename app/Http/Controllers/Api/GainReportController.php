<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Infrastructure\ApiResponse;
use App\Repositories\GainReportRepository;
use Illuminate\Http\Request;

class GainReportController extends Controller
{
    use ApiResponse;
    private GainReportRepository $repository;

    public function __construct(GainReportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index($farmId, Request $request)
    {
        $filters = $request->filters ?? [];

        $gains = $this->repository->gains($farmId, $filters);

        $single = $this->repository->single($farmId, $filters);

        $total_earring = $gains->count('earring');
        $total_gains_weight = $gains->sum('gains_kg');
        $total_less_weight = $gains->sum('less_weight');
        $total_start__weight = $gains->sum('start_weight');
        $total_final_weight = $gains->sum('final_weight');
        $total_single = $single->count();

        $response = [
            'total_earring' => $total_earring,
            'total_gains_weight' => $total_gains_weight,
            'total_less_weight' => $total_less_weight,
            'total_start_weight' => $total_start__weight,
            'total_final_weight' => $total_final_weight,
            'total_single' => $total_single,

            'itens' => $gains,
            'single' => $single,
        ];
        return $this->success('', $response);
    }
}
