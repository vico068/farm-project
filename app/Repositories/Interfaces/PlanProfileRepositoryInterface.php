<?php

namespace App\Repositories\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface PlanProfileRepositoryInterface extends BaseRepositoryInterface
{

    public function profilesByPlan($idPlan);
    public function plansByProfile($idProfile);
    public function profilesAvailableByPlan($idPlan, $filters, $filter);
    public function attachProfilesPlanByProfile($idPlan, $profiles);
    public function attachPlansByProfile($idProfile, $plans);
    public function detachPlansByProfile($idProfile, $plans);
    public function detachProfilePlan($idPlan, $idProfile);

}
