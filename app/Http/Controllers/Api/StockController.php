<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Infrastructure\ApiResponse;
use App\Models\Farm;
use App\Models\Movement;
use App\Repositories\StockRepository;
use Illuminate\Http\Request;

class StockController extends Controller
{
    use ApiResponse;

    private $repository;

    public function __construct(StockRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $farms = Farm::all();
        $stocks = [];

        $farms->each(function ($farm) use (&$stocks) {

            $entry = Movement::where('farm_id', $farm->id)->whereIn('operation', ['E', 'TE'])->count();
            $exit = Movement::where('farm_id', $farm->id)->whereIn('operation', ['S', 'TS'])->count();

            $stocks[] = [
                'farm_id' => $farm->id,
                'farm_name' => $farm->name,
                'stock' => $entry - $exit,
            ];
        });

        return $this->success('All Results.', $stocks);
    }

    public function advanced()
    {
        $stocks = $this->repository->advanced();
        return $this->success('All Results.', $stocks);
    }
}
