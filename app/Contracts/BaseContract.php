<?php
namespace App\Contracts;

interface BaseContract
{
    /**
     * Create a model instance.
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update a model instance.
     * @param array $attributes
     * @param int $id
     * @return mixed
     */
    public function update(array $attributes, int $id);

    /**
     * Return all Model rows.
     * @param string[] $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc');

    /**
     * Find one By ID
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * Find one By ID or throw an exception
     * @param int $id
     * @return mixed
     */
    public function findOneOrFail(int $id);

    /**
     * Find based on a different column
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data);

    /**
     * Find one based on a different column
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data);

    /**
     * Find one based on a different column or throw an exception
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data);

    /**
     * Soft Delete One By ID
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Permanent Delete One By ID
     * @param int $id
     * @return mixed
     */
    public function permanentDelete(int $id);
}
