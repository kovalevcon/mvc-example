<?php
declare(strict_types=1);
namespace Services;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ProductServiceRepository
 *
 * @package Services
 */
interface ProductServiceRepository
{
    /**
     * Generate need count of products
     *
     * @param int $counts
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function generateProducts($counts = 20): JsonResponse;

    /**
     * Show all items of Products model
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function showAllProducts(): JsonResponse;
}
