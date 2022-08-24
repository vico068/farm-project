<?php

namespace App\Services;

use App\Models\Animal;
use App\Repositories\Interfaces\AnimalRepositoryInterface;
use App\Services\Interfaces\AnimalServiceInterface;

class AnimalService implements AnimalServiceInterface
{

    /**
     * @var AnimalRepositoryInterface
     */
    protected AnimalRepositoryInterface $repository;

    public function __construct(AnimalRepositoryInterface $repository)
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
        // return $this->repository->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->repository->update($id, $attributes);
    }

    public function delete($id)
    {
        // return $this->repository->delete($id);
    }


    function getAllPaginate($n)
    {
        return $this->repository->getAllPaginate($n);
    }

    public function getByFarm($farmId){
        return $this->repository->getByFarm($farmId);
    }

}
