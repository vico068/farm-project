<?php

namespace App\Services;

use App\Repositories\Interfaces\AnimalRepositoryInterface;
use App\Services\Interfaces\AnimalServiceInterface;

class DashboardService
{

    /**
     * @var AnimalRepositoryInterface
     */
    protected AnimalRepositoryInterface $repository;

    public function __construct(AnimalRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $farmsCount = $this->repository->getAll()->count();

        $animalsActiveCount = $this->repository->getAll()->where('status', 'active')->count();

        $movementsSalesCount = $this->repository->getAll()->where('status', 'sold')->count();

        $movementsMortalityCount = $this->repository->getAll()->where('status', 'mortality')->count();

        $movementsBirthCount = $this->repository->getAll()->where('status', 'birth')->count();

        $usedCapacity = $this->repository->getAll()->sum('used_capacity');

        $stockByFarm = $this->repository->getAll()->groupBy('farm_id')->selectRaw('farm_id, sum(used_capacity) as used_capacity')->get();

    }

}
