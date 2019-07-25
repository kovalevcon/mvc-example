<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\Controller;
use App\Services\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class OrderController
 *
 * @package App\Controllers
 * @property \App\Services\OrderServiceRepository $service
 */
class OrderController extends Controller implements OrderControllerRepository
{
    /**
     * @inheritDoc
     */
    public function create(): JsonResponse
    {
        /** @var OrderService $service */
        $service = $this->getService(OrderService::class);
        return $service->createOrder();
    }

    /**
     * @inheritDoc
     */
    public function pay(): JsonResponse
    {
        /** @var OrderService $service */
        $service = $this->getService(OrderService::class);
        return $service->payOrder();
    }
}
