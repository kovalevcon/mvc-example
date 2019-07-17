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
            $this->router->parse($this->request);
            var_dump($this->router);
        } catch (Exception $e) {
            return Response::errorResponse($e);
        }
    }
}
