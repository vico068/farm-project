<?php

namespace App\Repositories\ACL\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPermissions($idRole);

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUsers($idRole);

    public function permissionsAvailable($idRole,  $filter = null);

    public function attachPermissionsRole($idRole,  array $permissions = []);

    public function detachPermissionRole($idRole, $idPermission);
}
