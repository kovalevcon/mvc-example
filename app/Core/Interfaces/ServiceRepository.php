<?php
declare(strict_types=1);
namespace App\Core\Interfaces;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ControllerRepository
 *
 * @package App\Core\Interfaces
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
