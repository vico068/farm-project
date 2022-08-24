<?php

namespace App\Services;

use App\Models\Collect;
use App\Repositories\CollectRepository;
use App\Repositories\Interfaces\CollectRepositoryInterface;
use App\Services\Interfaces\CollectServiceInterface;

class CollectService implements CollectServiceInterface
{

    /**
     * @var CollectRepositoryInterface
     */
    protected CollectRepositoryInterface $repository;

    public function __construct(CollectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }



    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById($id)
    {
        return $this->repository->getById($id);
    }

    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->repository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }


    function getAllPaginate($n)
    {
        return $this->repository->getAllPaginate($n);
    }
}
