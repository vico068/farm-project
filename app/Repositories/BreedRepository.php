<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Breed;
use App\Repositories\Interfaces\BreedRepositoryInterface;

class BreedRepository extends BaseRepository implements BreedRepositoryInterface
{
    public function __construct(Breed $model)
    {
        parent::__construct($model);
    }
}
