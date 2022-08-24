<?php

namespace App\Services;

use App\Models\Farm;
use App\Repositories\FarmRepository;
use App\Repositories\Interfaces\FarmRepositoryInterface;
use App\Services\Interfaces\FarmServiceInterface;

class FarmService implements FarmServiceInterface
{

    /**
     * @var FarmRepositoryInterface
     */
    protected FarmRepositoryInterface $repository;

    public function __construct(FarmRepositoryInterface $repository)
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
