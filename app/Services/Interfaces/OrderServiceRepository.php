<?php
declare(strict_types=1);
namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ProductServiceRepository
 *
 * @package App\Services
 */
interface OrderServiceRepository
{
    /**
     * Create order
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createOrder(): JsonResponse;

    /**
     * Paid order
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function payOrder(): JsonResponse;
}
