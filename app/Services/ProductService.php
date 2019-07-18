<?php
declare(strict_types=1);
namespace Services;

use Core\{Response, Service};
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductService
 *
 * @package Services
 */
class ProductService extends Service implements ProductServiceRepository
{
    /**
     * @inheritDoc
     */
    public function generateProducts($counts = 20): JsonResponse
    {
        try {
            $ids = [];
            for ($i = 0; $i < $counts; $i++) {
                ['id' => $identify, 'error' => $error] = $this->model->create([
                    'name' => 'Product' . mt_rand(),
                    'cost' => mt_rand() / mt_getrandmax() * mt_rand(10, 100),
                ]);

                $this->checkErrorModel($error);

                $ids[] = $identify;
            }
            return Response::successResponse(['ids' => $ids, 'count' => count($ids)]);
        } catch (Exception $e) {
            return Response::errorResponse($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function showAllProducts(): JsonResponse
    {
        return $this->showAll();
    }
}
