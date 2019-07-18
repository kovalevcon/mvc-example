<?php
declare(strict_types=1);
namespace Core;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Application
 *
 * @package Core
 */
class Application
{
    /**
     * Run application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function run(): JsonResponse
    {
        try {
            $this->config();
            /** @var Router $router */
            $router = (new Router)->parse(new Request);
            return (new Dispatcher($router))->dispatch();
        } catch (Exception $e) {
            return Response::errorResponse($e);
        }
    }

    /**
     * Configure application
     *
     * @throws \Exception
     */
    private function config(): void
    {
        require_once __DIR__ . '/../../config/core.php';
        require_once __DIR__ . '/../../config/db.php';
        Database::getInstance();
    }
}
