<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\MovementType;
use App\Repositories\Interfaces\MovementTypeRepositoryInterface;

class MovementTypeRepository extends BaseRepository implements MovementTypeRepositoryInterface
{
    public function __construct(MovementType $model)
    {
        parent::__construct($model);
    }
}
