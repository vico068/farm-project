<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Permission;
use App\Models\Plan;
use App\Models\Profile;
use App\Repositories\Interfaces\PermissionProfileRepositoryInterface;
use Illuminate\Http\Response;

class PermissionProfileRepository extends BaseRepository implements PermissionProfileRepositoryInterface
{
    protected $profile, $permission;

    public function __construct(Profile $profile, Permission $permission)
    {
        $this->profile = $profile;
        $this->permission = $permission;
        // parent::__construct($model);
    }


    public function getPermissionByProfile($idProfile)
    {

        $profile = $this->profile->find($idProfile);
        if (!$profile) {
            return $this->responseNotFound();
        }

        $permissions = $profile->permissions()->get();

        return $this->success('Found', [
            'permissions' => $permissions,
            'profile' => $profile,
        ]);
    }

    public function getProfileByPermission($idPermission)
    {

        $permission = $this->permission->find($idPermission);
        if (!$permission) {
            return $this->responseNotFound();
        }

        $profiles = $permission->profiles()->get();

        return $this->success('Found', [
            'permission' => $permission,
            'profiles' => $profiles,
        ]);
    }


    public function permissionsAvailable($idProfile, $filters, $filter)
    {
        if (!$profile = $this->profile->find($idProfile)) {
            return $this->responseNotFound();
        }

        $permissions = $profile->permissionsAvailable($filter);

        return $this->success('Found', [
            'permissions' => $permissions,
            'profile' => $profile,
            'filters' => $filters,
        ]);
    }

    public function attachPermissionsProfile($idProfile, array $permissions)
    {
        if (!$profile = $this->profile->find($idProfile)) {
            return $this->responseNotFound();
        }

        if (!$permissions || count($permissions) == 0) {
            return $this->error('Precisa escolher pelo menos uma permissão', Response::HTTP_BAD_REQUEST);
        }

        $profile->permissions()->sync($permissions);

        return $this->success('Attached Success');
    }

    public function detachPermissionProfile($idProfile, $idPermission)
    {
        $profile = $this->profile->find($idProfile);
        $permission = $this->permission->find($idPermission);

        if (!$profile || !$permission) {
            return $this->responseNotFound();
        }

        $profile->permissions()->detach($permission);

        return $this->success('Attached Success');

    }
}
