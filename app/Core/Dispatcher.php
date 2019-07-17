<?php
declare(strict_types=1);
namespace Core;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Dispatcher
 *
 * @package Core
 */
class Dispatcher implements DispatcherInterface
{
    /** @var Router $router */
    private $router;

    /**
     * Dispatcher constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Dispatch method in needed controller
     *
     * @return JsonResponse
     */
    public function dispatch(): JsonResponse
    {
        /** @var Controller $controller */
        $controller = $this->loadController();
        return $controller->{$this->router->method}($this->router->params);
    }

    /**
     * Load needed controller
     *
     * @return Controller
     */
    private function loadController(): Controller
    {
        $controllerName = "Controllers\\{$this->router->controller}";
        return new $controllerName;
    }
}
