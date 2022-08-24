<?php

namespace App\Repositories\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface AnimalRepositoryInterface extends BaseRepositoryInterface
{

    public function getByFarm($farmId);

}
