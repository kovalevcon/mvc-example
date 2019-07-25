<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\Controller;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductController
 *
 * @package App\Controllers
 * @property \App\Services\ProductServiceRepository $service
 */
class ProductController extends Controller implements ProductControllerRepository
{
    /**
     * @inheritDoc
     */
    public function generate(): JsonResponse
    {
        /** @var ProductService $service */
        $service = $this->getService(ProductService::class);
        return $service->generateProducts();
    }

    /**
     * @inheritDoc
     */
    public function show(): JsonResponse
    {
        /** @var ProductService $service */
        $service = $this->getService(ProductService::class);
        return $service->showAllProducts();
    }
}
