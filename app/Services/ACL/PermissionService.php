<?php
namespace App\Services\ACL;

use App\Repositories\ACL\Interfaces\PermissionRepositoryInterface;
use App\Services\ACL\Interfaces\PermissionServiceInterface;

class PermissionService implements PermissionServiceInterface
{

    /**
     * @var PermissionRepositoryInterface
     */
    protected PermissionRepositoryInterface $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getRoles($idPermission){
        return $this->repository->getRoles($idPermission);
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
