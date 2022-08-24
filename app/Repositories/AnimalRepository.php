<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Animal;
use App\Repositories\Interfaces\AnimalRepositoryInterface;
use Illuminate\Http\Response;

class AnimalRepository extends BaseRepository implements AnimalRepositoryInterface
{
    public function __construct(Animal $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Animal
     */
    public function getByFarmIdAndId($farmId, $id)
    {
        return $this->model->where('farm_id', $farmId)->where('id', $id)->first();
    }

    public function getByFarm($farmId)
    {
        try {
            $all = $this->model->where('farm_id', $farmId)->get();

            return $this->success('All Results', $all, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->error('Not registered', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
