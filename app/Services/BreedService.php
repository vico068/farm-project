<?php

namespace App\Services;

use App\Repositories\Interfaces\BreedRepositoryInterface;
use App\Services\Interfaces\BreedServiceInterface;

class BreedService implements BreedServiceInterface
{

    /**
     * @var BreedRepositoryInterface
     */
    protected BreedRepositoryInterface $repository;

    public function __construct(BreedRepositoryInterface $repository)
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
