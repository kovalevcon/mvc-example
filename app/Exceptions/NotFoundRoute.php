<?php
declare(strict_types=1);
namespace Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotFoundRoute
 *
 * @package Exceptions
 */
class NotFoundRoute extends Exception
{
    /** @var string $message */
    protected $message = 'Not found route.';
    /** @var int $code */
    protected $code = Response::HTTP_NOT_FOUND;
}
