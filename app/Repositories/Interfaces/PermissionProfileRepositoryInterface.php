<?php

namespace App\Repositories\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface PermissionProfileRepositoryInterface extends BaseRepositoryInterface
{

    public function getPermissionByProfile($idProfile);
    public function getProfileByPermission($idPermission);
    public function permissionsAvailable($idProfile, $filters, $filter);
    public function attachPermissionsProfile($idProfile, array $permissions);
    public function detachPermissionProfile($idProfile, $idPermission);

}
