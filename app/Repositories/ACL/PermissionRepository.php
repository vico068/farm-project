<?php
namespace App\Repositories\ACL;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Permission;
use App\Repositories\ACL\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Response;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getRoles($idPermission)
    {

        $permission = $this->model->find($idPermission);

        if (!$permission) {
            return $this->error('Permission not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success('All Results', $permission->roles, Response::HTTP_OK);

    }
}
