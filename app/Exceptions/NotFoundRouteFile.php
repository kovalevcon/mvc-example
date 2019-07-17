<?php
declare(strict_types=1);
namespace Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotFoundRouteFile
 *
 * @package Exceptions
 */
class NotFoundRouteFile extends Exception
{
    /** @var string $message */
    protected $message = 'Not found routes file.';
    /** @var int $code */
    protected $code = Response::HTTP_NOT_FOUND;
}
