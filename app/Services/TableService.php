<?php

namespace App\Services;

use App\Services\Interfaces\TableServiceInterface;
use App\Services\Interfaces\TenantServiceInterface;

class TableService
{
    protected $table, $tenantRepository;

    public function __construct(
        TableServiceInterface $table,
        TenantServiceInterface $tenantRepository
    ) {
        $this->table = $table;
        $this->tenantRepository = $tenantRepository;
    }

    public function getTablesByUuid(string $uuid)
    {
        $tenant = $this->tenantRepository->getTenantByUuid($uuid);

        return $this->table->getTablesByTenantId($tenant->id);
    }

    public function getTableByUuid(string $uuid)
    {
        return $this->table->getTableByUuid($uuid);
    }
}
