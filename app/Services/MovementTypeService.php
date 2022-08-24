<?php

namespace App\Services;

use App\Repositories\Interfaces\MovementTypeRepositoryInterface;
use App\Services\Interfaces\MovementTypeServiceInterface;

class MovementTypeService implements MovementTypeServiceInterface
{

    /**
     * @var MovementTypeRepositoryInterface
     */
    protected MovementTypeRepositoryInterface $repository;

    public function __construct(MovementTypeRepositoryInterface $repository)
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
