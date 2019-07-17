<?php
declare(strict_types=1);
namespace Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface OrderControllerInterface
 *
 * @package Controllers
 */
interface OrderControllerInterface
{
    /**
     * Method for create order
     *
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(array $params): JsonResponse;

    /**
     * Method for pay order
     *
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function pay(array $params): JsonResponse;
}
