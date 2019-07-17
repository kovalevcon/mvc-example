<?php
declare(strict_types=1);
namespace Core;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface DispatcherInterface
 *
 * @package Core
 */
interface DispatcherInterface
{
    /**
     * Dispatch method in needed controller
     *
     * @return JsonResponse
     */
    public function dispatch(): JsonResponse;
}
