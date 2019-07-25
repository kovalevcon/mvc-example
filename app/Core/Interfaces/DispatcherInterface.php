<?php
declare(strict_types=1);
namespace App\Core\Interfaces;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface DispatcherInterface
 *
 * @package App\Core\Interfaces
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
