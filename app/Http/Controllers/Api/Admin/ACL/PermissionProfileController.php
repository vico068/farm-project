<?php

namespace App\Http\Controllers\Api\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PermissionProfileRepositoryInterface;
use Illuminate\Http\Request;

class PermissionProfileController extends Controller
{
    protected PermissionProfileRepositoryInterface $permissionProfileRepository;
    public function __construct(PermissionProfileRepositoryInterface $permissionProfileRepository)
    {
        $this->permissionProfileRepository = $permissionProfileRepository;
        // $this->middleware(['can:profiles']);
    }

    public function permissions($idProfile)
    {
        return $this->permissionProfileRepository->getPermissionByProfile($idProfile);
    }

    public function profiles($idPermission)
    {
        return $this->permissionProfileRepository->getProfileByPermission($idPermission);
    }

    public function permissionsAvailable(Request $request, $idProfile)
    {
        $filters = $request->except('_token');
        return $this->permissionProfileRepository->permissionsAvailable($idProfile, $filters, $request->filter);
    }

    public function attachPermissionsProfile(Request $request, $idProfile)
    {
        $permissions = $request->permissions;
        return $this->permissionProfileRepository->attachPermissionsProfile($idProfile, $permissions);
    }

    public function detachPermissionProfile($idProfile, $idPermission)
    {
        return $this->permissionProfileRepository->detachPermissionProfile($idProfile, $idPermission);
    }
}
