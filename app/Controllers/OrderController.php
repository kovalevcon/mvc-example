<?php
declare(strict_types=1);
namespace Controllers;

use Core\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class OrderController
 *
 * @package Controllers
 * @property \Services\OrderServiceRepository $service
 */
class OrderController extends Controller implements OrderControllerRepository
{
    /**
     * @inheritDoc
     */
    public function create(array $params): JsonResponse
    {
        return $this->service->createOrder($params);
    }

    /**
     * @inheritDoc
     */
    public function pay(array $params): JsonResponse
    {
        return $this->service->payOrder($params);
    }
}
