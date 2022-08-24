<?php

namespace App\Http\Controllers\Api\Admin\ACL;



use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PlanProfileRepositoryInterface;
use Illuminate\Http\Request;

class PlanProfileController extends Controller
{
    protected PlanProfileRepositoryInterface $repository;
    public function __construct(PlanProfileRepositoryInterface $repository)
    {
        $this->repository = $repository;

        // $this->middleware(['can:plans']);
    }

    public function profiles($idPlan)
    {
        return $this->repository->profilesByPlan($idPlan);
    }

    public function plans($idProfile)
    {
        return $this->repository->plansByProfile($idProfile);
    }


    public function profilesAvailable(Request $request, $idPlan)
    {
        $filters = $request->except('_token');
        return $this->repository->profilesAvailableByPlan($idPlan, $filters, $request->filter);
    }


    public function attachProfilesPlan(Request $request, $idPlan)
    {
        return $this->repository->attachProfilesPlanByProfile($idPlan, $request->profiles);
    }

    public function detachProfilePlan($idPlan, $idProfile)
    {
        return $this->repository->detachProfilePlan($idPlan, $idProfile);
    }

    public function attachPlanByProfile(Request $request, $idProfile)
    {
        return $this->repository->attachPlansByProfile($idProfile, $request->plans);
    }

    public function detachPlanByProfile(Request $request, $idProfile)
    {
        return $this->repository->detachPlansByProfile($idProfile,  $request->plans);
    }
}
