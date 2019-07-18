<?php
declare(strict_types=1);
namespace Core;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ControllerRepository
 *
 * @package Core
 */
interface ServiceRepository
{
    /**
     * Show all items of model
     *
     * @return JsonResponse
     */
    public function showAll(): JsonResponse;
}
