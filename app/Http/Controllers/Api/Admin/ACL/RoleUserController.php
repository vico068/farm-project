<?php

namespace App\Http\Controllers\Api\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ACL\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
        /**
     * @var PermissionServiceInterface
     */
    protected RoleServiceInterface $roleService;


    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userService;


    /**
     * PermissionRoleController constructor.
     *
     * @param RoleServiceInterface $roleService
     * @param UserRepositoryInterface $userService
     */
    public function __construct(RoleServiceInterface $roleService, UserRepositoryInterface $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
    }

    public function roles($userId)
    {
        return $this->userService->getRoles($userId);
    }

    public function rolesAvailable(Request $request, $userId)
    {
        return $this->userService->rolesAvailable($userId,  $request->filter);
    }


    public function attachRolesUser(Request $request, $userId)
    {
        return $this->userService->attachRolesUser($userId,  $request->roles);
    }


    public function detachRoleUser($idUser, $idRole)
    {
        return $this->userService->detachUserRole($idUser, $idRole);

    }

    public function users($roleId)
    {
        return $this->roleService->getUsers($roleId);
    }
}
