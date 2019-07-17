<?php
declare(strict_types=1);
namespace Controllers;

use Core\BaseController;
use Core\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class OrderController
 *
 * @package Controllers
 */
class OrderController extends BaseController implements OrderControllerInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $params): JsonResponse
    {
        return Response::successResponse('OK');
    }

    /**
     * @inheritDoc
     */
    public function pay(array $params): JsonResponse
    {
        return Response::successResponse('OK');
    }
}
