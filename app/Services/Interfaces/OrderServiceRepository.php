<?php
declare(strict_types=1);
namespace Services;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ProductServiceRepository
 *
 * @package Services
 */
interface OrderServiceRepository
{
    /**
     * Create order
     *
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createOrder(array $params): JsonResponse;

    /**
     * Paid order
     *
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function payOrder(array $params): JsonResponse;
}
