<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePlan;
use App\Infrastructure\ApiResponse;
use App\Repositories\Interfaces\PlanRepositoryInterface;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use ApiResponse;
    private PlanRepositoryInterface $repository;
    public function __construct(PlanRepositoryInterface $repository)
    {
        $this->repository = $repository;

        //$this->middleware(['can:plans']);
    }

    public function index()
    {
        return $this->repository->getAll();
    }

    public function store(StoreUpdatePlan $request)
    {
        return $this->repository->create($request->all());
    }

    public function show($url)
    {
        return $this->repository->getByUrl($url);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        return $this->repository->search($filters, $request->filter);
    }

    public function update(StoreUpdatePlan $request, $id)
    {
        return $this->repository->update($id, $request->all());
    }
}
