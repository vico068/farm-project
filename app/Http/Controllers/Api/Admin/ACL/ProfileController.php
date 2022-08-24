<?php

namespace App\Http\Controllers\Api\Admin\ACL;

use App\Http\Requests\StoreUpdateProfile;
use App\Http\Controllers\Controller;
use App\Repositories\ACL\Interfaces\ProfileRepositoryInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileRepositoryInterface $service;

    public function __construct(ProfileRepositoryInterface $service)
    {
        $this->service = $service;

        //$this->middleware(['can:profiles']);
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
     * @param  \App\Http\Requests\StoreUpdateProfile  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProfile $request)
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
     * @param  \App\Http\Requests\StoreUpdateProfile  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProfile $request, $id)
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
    // public function search(Request $request)
    // {
    //     $filters = $request->only('filter');

    //     $profiles = $this->service
    //         ->where(function ($query) use ($request) {
    //             if ($request->filter) {
    //                 $query->where('name', $request->filter);
    //                 $query->orWhere('description', 'LIKE', "%{$request->filter}%");
    //             }
    //         })
    //         ->paginate();

    //     return view('admin.pages.profiles.index', compact('profiles', 'filters'));
    // }
}
