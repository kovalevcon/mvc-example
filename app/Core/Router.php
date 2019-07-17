<?php
declare(strict_types=1);
namespace Core;

use Exception;
use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class Router
{
    public $controller;
    public $method;

    /**
     * Parse request
     *
     * @param \Core\Request $request
     * @return \Core\Router
     * @throws \Exception
     */
    public function parse(Request $request): Router
    {
        try {
            /** @var YamlFileLoader $loader */
            $loader = new YamlFileLoader(new FileLocator([__DIR__ . '/../../routes/']));
            /** @var RequestContext $context */
            $context = new RequestContext();
            $context->fromRequest($request->symfonyRequest);
            /** @var UrlMatcher $matcher */
            $matcher = new UrlMatcher($loader->load('routes.yaml'), $context);

            ['controller' => $this->controller, 'method' => $this->method] = $matcher->match($context->getPathInfo());

            return $this;
        } catch (ResourceNotFoundException | FileLocatorFileNotFoundException $e) {
            throw new RouteNotFoundException($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (MethodNotAllowedException $e) {
            throw new Exception('Method now allowed.', Response::HTTP_METHOD_NOT_ALLOWED);
        } catch (Exception $e) {
            var_dump($e);
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
