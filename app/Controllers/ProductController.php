<?php
declare(strict_types=1);
namespace Controllers;

use Core\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductController
 *
 * @package Controllers
 * @property \Services\ProductServiceRepository $service
 */
class ProductController extends Controller implements ProductControllerRepository
{
    /**
     * @inheritDoc
     */
    public function generate(): JsonResponse
    {
        return $this->service->generateProducts();
    }

    /**
     * @inheritDoc
     */
    public function show(): JsonResponse
    {
        return $this->service->showAllProducts();
    }
}
