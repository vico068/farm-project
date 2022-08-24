<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Plan;
use App\Repositories\Interfaces\PlanRepositoryInterface;
use Illuminate\Http\Response;

class PlanRepository extends BaseRepository implements PlanRepositoryInterface
{
    public function __construct(Plan $model)
    {
        parent::__construct($model);
    }


    public function getAll()
    {

        $model = $this->model->with('details')->get();
        if (!$model) {
            return $this->responseNotFound();
        }

        return $this->success('Found', $model, Response::HTTP_OK);
    }

    public function getByUrl($url)
    {
        $model = $this->model->where('url', $url)->first();
        if (!$model) {
            return $this->responseNotFound();
        }

        return $this->success('Found', $model, Response::HTTP_OK);
    }

    public function update($id, array $attributes)
    {
        try {

            $model = $this->model->find($id);

            if (!$model) {
                return $this->responseNotFound();
            }

            if ($model->update($attributes)) {
                return $this->success('Updated', $model, Response::HTTP_CREATED);
            }
        } catch (\Throwable $th) {
            return $this->error('Not Updated', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function search($filters, $attributes)
    {

        $plans = $this->repository->search($attributes);

        return $this->success('Found',  ['plans' => $plans, 'filters' => $filters], Response::HTTP_OK);

    }

    public function delete($id)
    {
        $model = $this->model->with('details')->where('id', $id)->first();
        if (!$model) {
            return $this->responseNotFound();
        }

        if ($model->details->count() > 0) {
           return $this->error("Existem detahes vinculados a esse plano, portanto não pode deletar", Response::HTTP_NOT_FOUND);
        }

        if ($model->tenants->count() > 0) {
            return $this->error("Existem Companias vinculadas a esse plano, portanto não pode deletar", Response::HTTP_NOT_FOUND);
         }

        return $this->success('Deleted!', $model);
        $model->delete();

        return $this->success('Deleted!');
    }
}
