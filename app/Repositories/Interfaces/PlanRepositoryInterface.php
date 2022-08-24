<?php

namespace App\Repositories\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface PlanRepositoryInterface extends BaseRepositoryInterface
{

    public function getByUrl($url);

    public function search($filters, $attributes);

}
