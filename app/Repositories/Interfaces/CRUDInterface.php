<?php

namespace App\Repositories\Interfaces;

interface CRUDInterface
{
    /**
     * Handles getting all items in the database.
     *
     * @param $data
     * @return mixed
     */
    public function get(array $data);

    /**
     * Handles getting an item by id.
     *
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Handles creating an item into the database;
     *
     * @param $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Handles updating an item from database.
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Handles deleting an item from database.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);
}
