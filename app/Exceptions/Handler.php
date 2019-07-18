<?php
declare(strict_types=1);
namespace Exceptions;

use Exception;
use PDOException;
use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\{
    MethodNotAllowedException,
    NoConfigurationException,
    ResourceNotFoundException
};

/**
 * Class Handler
 *
 * @package Exceptions
 */
class Handler
{
    /** @var array $dict */
    private static $dict = [
        ResourceNotFoundException::class        => NotFoundRoute::class,
        NoConfigurationException::class         => NotFoundRoute::class,
        FileLocatorFileNotFoundException::class => NotFoundRouteFile::class,
        MethodNotAllowedException::class        => MethodNotAllow::class,
        PDOException::class                     => PDOErrorException::class,
    ];

    /**
     * Handle all exceptions
     *
     * @param \Exception $exception
     * @throws \Exception
     */
    public static function handle(Exception $exception): void
    {
        $newName = self::$dict[get_class($exception)] ?? null;
        if (is_null($newName)) {
            if ($exception->getCode() === 0) {
                throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            throw $exception;
        }

        throw new $newName;
    }
}
