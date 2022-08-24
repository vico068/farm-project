<?php

namespace App\Repositories\Interfaces;

use App\Infrastructure\Repository\BaseRepositoryInterface;

interface CollectRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * @param int $collectId
     * @return \Illuminate\Database\Eloquent\Collection
    */
    public function movements($collectId);
}
