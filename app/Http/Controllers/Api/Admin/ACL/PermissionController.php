<?php

namespace App\Http\Controllers\Api\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Services\ACL\Interfaces\PermissionServiceInterface;
use Illuminate\Http\Request;
//teste 1234
class PermissionController extends Controller
{
        /**
     * @var PermissionServiceInterface
     */
    protected PermissionServiceInterface $service;

    public function __construct(PermissionServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->getById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
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

        $permissions = $this->repository
                            ->where(function($query) use ($request) {
                                if ($request->filter) {
                                    $query->where('name', $request->filter);
                                    $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                                }
                            })
                            ->get();

        return view('admin.pages.permissions.index', compact('permissions', 'filters'));
    }
}
