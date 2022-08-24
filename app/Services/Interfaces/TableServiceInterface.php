<?php

namespace App\Services\Interfaces;


interface TableServiceInterface
{
    public function getTablesByTenantUuid(string $uuid);
    public function getTablesByTenantId(int $idTenant);
    public function getTableByUuid(string $uuid);
}
