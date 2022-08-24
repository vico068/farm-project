<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Permission;
use App\Models\Plan;
use App\Models\Profile;
use App\Repositories\Interfaces\PlanProfileRepositoryInterface;
use Illuminate\Http\Response;

class PlanProfileRepository extends BaseRepository implements PlanProfileRepositoryInterface
{
    protected $profile, $plan;

    public function __construct(Profile $profile, Plan $plan)
    {
        $this->profile = $profile;
        $this->plan = $plan;
    }

    public function profilesByPlan($idPlan)
    {
        if (!$plan = $this->plan->find($idPlan)) {
            return $this->responseNotFound();
        }

        $profiles = $plan->profiles()->get();

        return $this->success('Found', [
            'plan' => $plan,
            'profiles' => $profiles,
        ]);
    }

    public function plansByProfile($idProfile)
    {
        if (!$profile = $this->profile->find($idProfile)) {
            return $this->responseNotFound();
        }

        $plans = $profile->plans()->get();

        return $this->success('Found', [
            'plans' => $plans,
            'profile' => $profile,
        ]);
    }

    public function profilesAvailableByPlan($idPlan, $filters, $filter)
    {
        if (!$plan = $this->plan->find($idPlan)) {
            return $this->responseNotFound();
        }

        $profiles = $plan->profilesAvailable($filter);

        return $this->success('Found', [
            'plan' => $plan,
            'profiles' => $profiles,
            'filters' => $filters,
        ]);
    }

    public function attachProfilesPlanByProfile($idPlan, $profiles)
    {
        if (!$plan = $this->plan->find($idPlan)) {
            return $this->responseNotFound();
        }

        if (!$profiles || count($profiles) == 0) {
            return $this->error('Precisa escolher pelo menos um plano', Response::HTTP_BAD_REQUEST);
        }

        $plan->profiles()->attach($profiles);

        return $this->success('Attached Success');
    }

    public function attachPlansByProfile($idProfile, $plans)
    {
        if (!$profile = $this->profile->find($idProfile)) {
            return $this->responseNotFound();
        }

        if (!$plans || count($plans) == 0) {
            return $this->error('Precisa escolher pelo menos um plano', Response::HTTP_BAD_REQUEST);
        }

        $profile->plans()->attach($plans);

        return $this->success('Attached Success');
    }

    public function detachPlansByProfile($idProfile, $plans)
    {
        if (!$plan = $this->profile->find($idProfile)) {
            return $this->responseNotFound();
        }

        if (!$plans || count($plans) == 0) {
            return $this->error('Precisa escolher pelo menos um plano', Response::HTTP_BAD_REQUEST);
        }

        $plan->plans()->detach($plans);

        return $this->success('Attached Success');
    }

    public function detachProfilePlan($idPlan, $idProfile)
    {
        $plan = $this->plan->find($idPlan);
        $profile = $this->profile->find($idProfile);

        if (!$plan || !$profile) {
            return $this->responseNotFound();
        }

        $plan->profiles()->detach($profile);

        return $this->success('Attached Success');
    }
}
