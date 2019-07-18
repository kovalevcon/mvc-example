<?php
declare(strict_types=1);
namespace Core;

use Exception;
use Exceptions\Handler;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Service
 *
 * @package Core
 */
abstract class Service implements ServiceRepository
{
    /** @var ModelRepository $model */
    protected $model;

    /**
     * BaseController constructor.
     *
     * @param ModelRepository $model
     */
    public function __construct(ModelRepository $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function showAll(): JsonResponse
    {
        try {
            ['items' => $items, 'error' => $error] = $this->model->showAll();
            $this->checkErrorModel($error);
            return Response::successResponse(['items' => $items, 'count' => count($items)]);
        } catch (Exception $e) {
            return Response::errorResponse($e);
        }
    }

    /**
     * Check error in model response
     *
     * @param string|null $error
     * @throws \Exception
     */
    protected function checkErrorModel(?string $error): void
    {
        if ($error) {
            Handler::handle(new Exception($error));
        }
    }
}
