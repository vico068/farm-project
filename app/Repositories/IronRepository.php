<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Iron;
use App\Repositories\Interfaces\IronRepositoryInterface;

class IronRepository extends BaseRepository implements IronRepositoryInterface
{
    public function __construct(Iron $model)
    {
        parent::__construct($model);
    }
}
