<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Infrastructure\ApiResponse;
use App\Repositories\Interfaces\CollectRepositoryInterface;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    use ApiResponse;
    private CollectRepositoryInterface $repository;
    public function __construct(CollectRepositoryInterface $repository)
    {
        $this->repository = $repository;

    }

    public function movements($id)
    {
        return $this->repository->movements($id);
    }

    public function index()
    {
        return $this->repository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
