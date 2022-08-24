<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Interfaces\BaseCRUDInterface;

interface BaseRepositoryInterface
{

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll();


    /**
     * Execute the query and get the first result.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public function getById($id);


    /**
     * Create a new model.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function create(array $attributes);


    /**
     * Update a model.
     *
     * @param  mixed  $id
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $attributes);

    /**
     * Delete a model.
     *
     * @param  mixed  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function delete($id);

    public function getAllPaginate($n);
}
