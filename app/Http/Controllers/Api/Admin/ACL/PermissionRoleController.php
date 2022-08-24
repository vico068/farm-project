<?php

namespace App\Http\Controllers\Api\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Services\ACL\Interfaces\PermissionServiceInterface;
use App\Services\ACL\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{

    /**
     * @var PermissionServiceInterface
     */
    protected PermissionServiceInterface $permissionService;


    /**
     * @var RoleServiceInterface
     */
    protected RoleServiceInterface $roleService;


    /**
     * PermissionRoleController constructor.
     *
     * @param PermissionServiceInterface $permissionService
     * @param RoleServiceInterface $roleService
     */
    public function __construct(PermissionServiceInterface $permissionService, RoleServiceInterface $roleService)
    {
        $this->permissionService = $permissionService;
        $this->roleService = $roleService;
    }

    public function permissions($idRole)
    {
        return $this->roleService->getPermissions($idRole);
    }

    public function permissionsAvailable(Request $request, $idRole)
    {
        return $this->roleService->permissionsAvailable($idRole,  $request->filter);
    }


    public function attachPermissionsRole(Request $request, $idRole)
    {
        return $this->roleService->attachPermissionsRole($idRole,  $request->permissions);
    }


    public function detachPermissionRole($idRole, $idPermission)
    {
        return $this->roleService->detachPermissionRole($idRole, $idPermission);

    }

    public function roles($idPermission)
    {
        return $this->permissionService->getRoles($idPermission);
    }

}
