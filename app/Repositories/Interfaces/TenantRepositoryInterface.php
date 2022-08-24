<?php
namespace App\Repositories\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface TenantRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllTenants(int $per_page);
    public function getTenantByUuid(string $uuid);
    public function updateTenant($id, array $attributes):bool;
}
