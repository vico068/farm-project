<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Tenant;
use App\Repositories\Interfaces\TenantRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\ItemNotFoundException;

class TenantRepository extends BaseRepository implements TenantRepositoryInterface
{
    protected $entity;

    public function __construct(Tenant $tenant)
    {
        $this->entity = $tenant;
    }

    public function getAllTenants($per_page)
    {
        return $this->entity->paginate($per_page);
    }

    public function getTenantByUuid(string $uuid)
    {
        return $this->entity
                        ->where('uuid', $uuid)
                        ->first();
    }

    public function updateTenant($id, array $attributes):bool
    {
        try {
            $model = $this->model->find($id);
            if (!$model) {
               throw new \Exception(ItemNotFoundException::class);
            }

            return $model->update($attributes);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
