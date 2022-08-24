<?php

namespace App\Repositories\ACL;

use App\Infrastructure\ApiResponse;
use App\Infrastructure\Repository\BaseRepository;
use App\Models\Role;
use App\Repositories\ACL\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Response;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    use ApiResponse;

    /**
     * @var Role
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getPermissions($idRole)
    {
        $role = $this->model->find($idRole);

        if (!$role) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success('All Results', $role->permissions, Response::HTTP_OK);
    }

    public function getUsers($idRole)
    {
        $role = $this->model->find($idRole);

        if (!$role) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success('All Results', $role->users, Response::HTTP_OK);
    }

    public function permissionsAvailable($idRole, $filter = null)
    {
        $role = $this->model->find($idRole);

        if (!$role) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        $permissions = $role->permissionsAvailable($filter);

        return $this->success('All Results', $permissions, Response::HTTP_OK);
    }


    public function attachPermissionsRole($idRole,  array $permissions = [])
    {

        if (!$permissions || count($permissions) == 0) {
            return $this->error('Permission is required', Response::HTTP_NOT_FOUND);
        }

        $role = $this->model->find($idRole);

        if (!$role) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        $permissions = $role->attachPermissionsRole($permissions);

        return $this->success('Attached Successful', $permissions, Response::HTTP_OK);
    }

    public function detachPermissionRole($idRole, $idPermission)
    {

        $role = $this->model->find($idRole);

        if (!$role) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        $permission = $role->permissions()->find($idPermission);

        if (!$permission) {
            return $this->error('Permission not found', Response::HTTP_NOT_FOUND);
        }

        $role->permissions()->detach($permission);

        return $this->success('Detach Successful', $permission, Response::HTTP_OK);
    }
}
