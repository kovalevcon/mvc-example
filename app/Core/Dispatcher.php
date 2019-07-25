<?php
declare(strict_types=1);
namespace App\Core;

use App\Core\Interfaces\ControllerRepository;
use App\Core\Interfaces\DispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Dispatcher
 *
 * @package App\Core
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
        return $controller->{$this->router->method}();
    }

    /**
     * Load needed controller
     *
     * @return ControllerRepository
     */
    private function loadController(): ControllerRepository
    {
        $controllerName = "App\\Controllers\\{$this->router->controller}";
        $modelName = 'App\\Models\\' . str_replace('Controller', '', $this->router->controller);
        $serviceName = 'App\\Services\\' . str_replace('Controller', 'Service', $this->router->controller);
        return new $controllerName(
            [$serviceName => new $serviceName(new $modelName)]
        );
    }
}
