<?php

namespace App\Repositories\Interfaces;

interface TableRepositoryInterface
{
    public function getTablesByTenantUuid(string $uuid);
    public function getTablesByTenantId(int $idTenant);
    public function getTableByUuid(string $uuid);
}
