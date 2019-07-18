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
     * @inheritDoc
     */
    public function dispatch(): JsonResponse
    {
        /** @var ControllerRepository $controller */
        $controller = $this->loadController();
        return $controller->{$this->router->method}($this->router->params);
    }

    /**
     * Load needed controller
     *
     * @return ControllerRepository
     */
    private function loadController(): ControllerRepository
    {
        $controllerName = "Controllers\\{$this->router->controller}";
        $modelName = 'Models\\' . str_replace('Controller', '', $this->router->controller);
        $serviceName = 'Services\\' . str_replace('Controller', 'Service', $this->router->controller);
        return new $controllerName(new $serviceName(new $modelName));
    }
}
