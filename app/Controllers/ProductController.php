<?php
declare(strict_types=1);
namespace Controllers;

use Core\BaseController;
use Core\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductController
 *
 * @package Controllers
 */
class ProductController extends BaseController implements ProductControllerInterface
{
    /**
     * @inheritDoc
     */
    public function generate(): JsonResponse
    {
        return Response::successResponse('OK');
    }

    /**
     * @inheritDoc
     */
    public function show(): JsonResponse
    {
        return Response::successResponse('OK');
    }
}
