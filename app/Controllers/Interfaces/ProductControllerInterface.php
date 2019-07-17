<?php
declare(strict_types=1);
namespace Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ProductControllerInterface
 *
 * @package Controllers
 */
interface ProductControllerInterface
{
    /**
     * Method for generate products
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function generate(): JsonResponse;

    /**
     * Method for show products
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(): JsonResponse;
}
