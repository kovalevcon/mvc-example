<?php
declare(strict_types=1);
namespace Core;

use Exception;

class Application
{
    private $request;
    private $router;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->request = new Request;
        $this->router = new Router;
    }

    public function run()
    {
        try {
            $this->config();
            $this->router->parse($this->request);

            /** @var Dispatcher $dispatcher */
            $dispatcher = new Dispatcher($this->router);
            return $dispatcher->dispatch();
        } catch (Exception $e) {
            return Response::errorResponse($e);
        }
    }

    private function config(): void
    {
        require_once __DIR__ . '/../../config/core.php';
        require_once __DIR__ . '/../../config/db.php';
    }
}
