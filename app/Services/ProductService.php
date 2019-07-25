<?php
declare(strict_types=1);
namespace App\Services;

use App\Core\Http\ResponseJson;
use App\Core\Service;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductService
 *
 * @package App\Services
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
            return ResponseJson::successResponse(['ids' => $ids, 'count' => count($ids)]);
        } catch (Exception $e) {
            return ResponseJson::errorResponse($e);
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
