<?php
declare(strict_types=1);
namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ProductControllerInterface
 *
 * @package App\Controllers
 */
interface ProductControllerRepository
{
    /**
     * Method for generate products
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \App\Core\Exceptions\ControllerException
     */
    public function generate(): JsonResponse;

    /**
     * Method for show products
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \App\Core\Exceptions\ControllerException
     */
    public function show(): JsonResponse;
}
