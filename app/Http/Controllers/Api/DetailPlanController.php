<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\StoreUpdateDetailPlan;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DetailPlanRepositoryInterface;
use Illuminate\Http\Request;

class DetailPlanController extends Controller
{
    private DetailPlanRepositoryInterface $repository;

    public function __construct(DetailPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;

        // $this->middleware(['can:plans']);
    }

    public function index($urlPlan)
    {
        return $this->repository->getAllByPlanUrl($urlPlan);
    }

    public function store(StoreUpdateDetailPlan $request, $urlPlan)
    {
        return $this->repository->createByPlanUrl($urlPlan, $request->all());
    }

    public function update(StoreUpdateDetailPlan $request, $urlPlan, $idDetail)
    {
        return $this->repository->updateByPlanUrl($urlPlan, $idDetail, $request->all());
    }

    public function show($urlPlan, $idDetail)
    {
        return $this->repository->findByPlanUrl($urlPlan, $idDetail);
    }

    public function destroy($urlPlan, $idDetail)
    {
        return $this->repository->deleteByPlanUrl($urlPlan, $idDetail);
    }
}
