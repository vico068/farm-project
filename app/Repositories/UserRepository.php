<?php

namespace App\Repositories;

use App\Infrastructure\ApiResponse;
use App\Infrastructure\Repository\BaseRepository;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Response;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    use ApiResponse;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        try {
            //tratar tenant
            // $all = $this->model->latest()->tenantUser();
            $all = $this->model->all();
            return $this->success('All Results', $all, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->error('Not registered', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRoles($userId)
    {
        $user = $this->model->find($userId);

        if (!$user) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success('All Results', $user->roles, Response::HTTP_OK);
    }

    public function rolesAvailable($userId, $filter = null)
    {
        $user = $this->model->find($userId);

        if (!$user) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        $roles = $user->rolesAvailable($filter);

        return $this->success('All Results', $roles, Response::HTTP_OK);
    }


    public function attachRolesUser($userId,  array $roles = [])
    {

        if (!$roles || count($roles) == 0) {
            return $this->error('Role is required', Response::HTTP_NOT_FOUND);
        }

        $user = $this->model->find($userId);

        if (!$user) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        $roles = $user->attachRolesUser($roles);

        return $this->success('Attached Successful', $roles, Response::HTTP_OK);
    }

    public function detachUserRole($userId, $roleId)
    {

        $user = $this->model->find($userId);

        if (!$user) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        $role = $user->roles()->find($roleId);

        if (!$role) {
            return $this->error('Role not found', Response::HTTP_NOT_FOUND);
        }

        $user->roles()->detach($role);

        return $this->success('Detach Successful', $role, Response::HTTP_OK);
    }
}
