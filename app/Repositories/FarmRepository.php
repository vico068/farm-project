<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Farm;
use App\Repositories\Interfaces\FarmRepositoryInterface;

class FarmRepository extends BaseRepository implements FarmRepositoryInterface
{
    public function __construct(Farm $model)
    {
        parent::__construct($model);
    }
}
