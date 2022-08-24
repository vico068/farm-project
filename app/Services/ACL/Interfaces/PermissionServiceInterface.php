<?php

namespace App\Services\ACL\Interfaces;

use App\Infrastructure\Interfaces\BaseCRUDInterface;

interface PermissionServiceInterface extends BaseCRUDInterface {

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getRoles($idPermission);

}
