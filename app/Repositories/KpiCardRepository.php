<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\KpiCard;
use App\Repositories\Interfaces\KpiCardRepositoryInterface;
use Illuminate\Http\Response;

class KpiCardRepository extends BaseRepository implements KpiCardRepositoryInterface
{
    public function __construct(KpiCard $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        try {
            $all = $this->model->with('movementType')->get();
            return $this->success('All Results', $all, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->error('Not registered', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
