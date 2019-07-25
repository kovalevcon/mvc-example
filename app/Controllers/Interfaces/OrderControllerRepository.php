<?php
declare(strict_types=1);
namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface OrderControllerInterface
 *
 * @package App\Controllers
 */
interface OrderControllerRepository
{
    /**
     * Method for create order
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \App\Core\Exceptions\ControllerException
     */
    public function create(): JsonResponse;

    /**
     * Method for pay order
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \App\Core\Exceptions\ControllerException
     */
    public function pay(): JsonResponse;
}
