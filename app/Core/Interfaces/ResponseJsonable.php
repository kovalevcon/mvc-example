<?php
declare(strict_types=1);
namespace App\Core\Interfaces;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ResponseJsonable
 *
 * @package App\Core\Interfaces
 */
interface ResponseJsonable
{
    /**
     * Return error response
     *
     * @param \Exception $exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function errorResponse(Exception $exception): JsonResponse;

    /**
     * Return success response
     *
     * @param string|array $payload
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function successResponse($payload): JsonResponse;
}
