<?php
declare(strict_types=1);
namespace App\Core\Interfaces;

/**
 * Interface ModelRepository
 *
 * @package App\Core\Interfaces
 */
interface ModelRepository
{
    /**
     * Create one item in table
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array;

    /**
     * Get all items in table
     *
     * @return array
     */
    public function showAll(): array;

    /**
     * Get one item by `id` in table
     *
     * @return array
     */
    public function show(int $id): array;

    /**
     * Edit one item by `id` in table
     *
     * @return array
     */
    public function edit(int $id, array $params): array;

    /**
     * Delete one item by `id` in table
     *
     * @return array
     */
    public function delete(int $id): array;
}
