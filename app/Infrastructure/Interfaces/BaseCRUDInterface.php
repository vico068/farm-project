<?php

namespace App\Infrastructure\Interfaces;

interface BaseCRUDInterface
{

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll();

    /**
     * Find a model in the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function getById($id);

    /**
     * Create a new model.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function create(array $request);

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
