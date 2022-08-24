<?php

namespace App\Repositories\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{

    public function getRoles($userId);

    public function rolesAvailable($userId, $filter = null);

    public function attachRolesUser($userId,  array $roles = []);

    public function detachUserRole($userId, $roleId);

}
