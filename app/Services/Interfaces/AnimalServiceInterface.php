<?php

namespace App\Services\Interfaces;

use App\Infrastructure\Interfaces\BaseCRUDInterface;

interface AnimalServiceInterface extends BaseCRUDInterface
{

    public function getByFarm($farmId);
}
