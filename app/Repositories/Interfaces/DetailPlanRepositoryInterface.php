<?php

namespace App\Repositories\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface DetailPlanRepositoryInterface extends BaseRepositoryInterface
{

    public function getAllByPlanUrl($urlPlan);
    public function createByPlanUrl($urlPlan, array $attributes);
    public function updateByPlanUrl($urlPlan, $idDetail, array $attributes);
    public function findByPlanUrl($urlPlan, $idDetail);
    public function deleteByPlanUrl($urlPlan, $idDetail);

}
