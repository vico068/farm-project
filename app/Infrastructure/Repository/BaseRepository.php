<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\ApiResponse;
use App\Infrastructure\Repository\BaseRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{

    use ApiResponse;


    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        try {
            $all = $this->model->all();
            return $this->success('All Results', $all, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->error('Not registered', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function getById($id)
    {

        $model = $this->model->find($id);
        if (!$model) {
            return $this->error("Not Found.", Response::HTTP_NOT_FOUND);
        }

        return $this->success('Found', $model, Response::HTTP_OK);
    }

    public function create(array $attributes)
    {
        try {
            $created = $this->model->create($attributes);
            return $this->success('Registered', $created, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->error('Not registered', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, array $attributes)
    {
        try {
            $model = $this->model->find($id);
            if (!$model) {
                return $this->error("Not Found.", Response::HTTP_NOT_FOUND);
            }

            if ($model->update($attributes)) {
                return $this->success('Updated', $model, Response::HTTP_CREATED);
            }
        } catch (\Throwable $th) {
            return $this->error('Not Updated', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $model = $this->model->find($id);
            if (!$model) {
                return $this->error("Not Found.", Response::HTTP_NOT_FOUND);
            }

            if ($model->delete()) {
                $model->update(['active' => false]);
                return $this->success('Deleted!', $model);
            }
            return $this->error('Not Deleted!', Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    function getAllPaginate($n)
    {
        return $this->model->paginate($n);
    }
}
