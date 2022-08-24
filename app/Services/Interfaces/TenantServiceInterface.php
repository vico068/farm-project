<?php
namespace App\Services\Interfaces;


use App\Infrastructure\Interfaces\BaseCRUDInterface;

interface TenantServiceInterface
{
    public function getAllTenants(int $per_page);
    public function getTenantByUuid(string $uuid);
}
