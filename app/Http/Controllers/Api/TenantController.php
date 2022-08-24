<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTenant;
use App\Infrastructure\ApiResponse;
use App\Models\Tenant;
use App\Repositories\Interfaces\TenantRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{

    use ApiResponse;

    private TenantRepositoryInterface $repository;

    public function __construct(TenantRepositoryInterface $repository)
    {
        $this->repository = $repository;

        // $this->middleware(['can:tenants']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateTenant  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTenant $request)
    {
        return $this->repository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * Update register by id
     *
     * @param  \App\Http\Requests\StoreUpdateTenant  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateTenant $request, $id)
    {
        if (!$tenant = Tenant::find($id)) {
            return $this->responseNotFound();
        }

        $data = $request->all();

        if ($request->hasFile('logo') && $request->logo->isValid()) {

            if (Storage::exists($tenant->logo)) {
                Storage::delete($tenant->logo);
            }

            $data['logo'] = $request->logo->store("tenants/{$tenant->uuid}");
        }

        $tenant->update($data);

        return $this->success('Updated', $tenant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$tenant = Tenant::find($id)) {
            return $this->responseNotFound();
        }

        if (Storage::exists($tenant->logo)) {
            Storage::delete($tenant->logo);
        }

        $tenant->delete();

        return $this->success('Deleted', $tenant);
    }


    /**
     * Search results
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $tenants = Tenant::where(function ($query) use ($request) {
            if ($request->filter) {
                $query->where('name', $request->filter);
            }
        })
            ->latest()
            ->paginate();

        return $this->success('Deleted', [
            'tenants' => $tenants,
            'filters' => $filters
        ]);
    }
}
