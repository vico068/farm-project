<?php

namespace App\Repositories\ACL\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getRoles($idPermission);
}
