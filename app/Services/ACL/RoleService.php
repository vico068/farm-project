<?php

namespace App\Services\ACL;

use App\Repositories\ACL\Interfaces\RoleRepositoryInterface;
use App\Services\ACL\Interfaces\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{

    /**
     * @var RoleRepositoryInterface
     */
    protected RoleRepositoryInterface $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPermissions($idRole)
    {
        return $this->repository->getPermissions($idRole);
    }

    public function getUsers($idRole)
    {
        return $this->repository->getUsers($idRole);
    }

    public function permissionsAvailable($idRole,  $filter = null)
    {
        return $this->repository->permissionsAvailable($idRole,  $filter);
    }

   public function attachPermissionsRole($idRole, array $permissions = []){
        return $this->repository->attachPermissionsRole($idRole, $permissions);
    }

    public function detachPermissionRole($idRole, $idPermission){
        return $this->repository->detachPermissionRole($idRole, $idPermission);
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
