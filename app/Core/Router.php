<?php
declare(strict_types=1);
namespace App\Core;

use App\Core\Exceptions\Handler;
use App\Core\Http\Request;
use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

/**
 * Class Router
 *
 * @package App\Core
 */
class Router
{
    /** @var string $controller */
    public $controller;
    /** @var string $method */
    public $method;
    /** @var array $params */
    public $params;

    /**
     * Parse request
     *
     * @param Request $request
     * @return Router
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
            /** @var array $matchArray */
            $matchArray = $matcher->match($context->getPathInfo());
            ['controller' => $this->controller, 'method' => $this->method] = $matchArray;
//            unset($matchArray['controller'], $matchArray['method'], $matchArray['_route']);
//            $this->params = array_merge($matchArray, $request->getJsonBody());

            return $this;
        } catch (Exception $e) {
            Handler::handle($e);
            return $this;
        }
    }
}
