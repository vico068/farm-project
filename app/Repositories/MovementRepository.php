<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Movement;
use App\Repositories\Interfaces\MovementRepositoryInterface;

class MovementRepository extends BaseRepository implements MovementRepositoryInterface
{
    public function __construct(Movement $model)
    {
        parent::__construct($model);
    }
}
