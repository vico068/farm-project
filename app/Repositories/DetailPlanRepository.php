<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\DetailPlan;
use App\Models\Plan;
use App\Repositories\Interfaces\DetailPlanRepositoryInterface;
use Illuminate\Http\Response;

class DetailPlanRepository extends BaseRepository implements DetailPlanRepositoryInterface
{
    protected $plan;

    public function __construct(DetailPlan $model, Plan $plan)
    {
        parent::__construct($model);
        $this->plan = $plan;
    }

    public function getAllByPlanUrl($urlPlan)
    {
        $plan = $this->plan->where('url', $urlPlan)->first();

        if (!$plan) {
            return $this->error("Not Found.", Response::HTTP_NOT_FOUND);
        }

        $details = $plan->details;

        return $this->success('Found', $details);
    }

    public function createByPlanUrl($urlPlan, array $attributes)
    {
        try {

            if (!$plan = $this->plan->where('url', $urlPlan)->first()) {
                return $this->error("Not Found.", Response::HTTP_NOT_FOUND);
            }

            $created = $plan->details()->create($attributes);

            return $this->success('Registered', $created, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->error('Not registered', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateByPlanUrl($urlPlan, $idDetail, array $attributes)
    {
        try {

            $plan = $this->plan->where('url', $urlPlan)->first();
            $detail = $this->model->find($idDetail);
            if (!$plan || !$detail) {
                return $this->error("Not Found.", Response::HTTP_NOT_FOUND);
            }

            $detail->update($attributes);

            if ($detail->update($attributes)) {
                return $this->success('Updated', $detail, Response::HTTP_CREATED);
            }
        } catch (\Throwable $th) {
            return $this->error('Not registered', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findByPlanUrl($urlPlan, $idDetail)
    {
        $plan = $this->plan->where('url', $urlPlan)->first();
        $detail = $this->model->find($idDetail);
        if (!$plan || !$detail) {
            return $this->error("Not Found.", Response::HTTP_NOT_FOUND);
        }

        return $this->success('Found', ['plan' => $plan,'detail' => $detail]);
    }

    public function deleteByPlanUrl($urlPlan, $idDetail)
    {
        $plan = $this->plan->where('url', $urlPlan)->first();
        $detail = $this->model->find($idDetail);

        if (!$plan || !$detail) {
            return $this->error("Not Found.", Response::HTTP_NOT_FOUND);
        }

        if ($detail->delete()) {
            return $this->success('Deleted!', $detail);
        }
        return $this->error('Not Deleted!', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
