<?php

namespace App\Services;

use App\Repositories\Interfaces\IronRepositoryInterface;
use App\Services\Interfaces\IronServiceInterface;

class IronService implements IronServiceInterface
{

    /**
     * @var IronRepositoryInterface
     */
    protected IronRepositoryInterface $repository;

    public function __construct(IronRepositoryInterface $repository)
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
