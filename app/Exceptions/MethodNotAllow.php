<?php
declare(strict_types=1);
namespace Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MethodNotAllow
 *
 * @package Exceptions
 */
class MethodNotAllow extends Exception
{
    /** @var string $message */
    protected $message = 'Method now allowed.';
    /** @var int $code */
    protected $code = Response::HTTP_METHOD_NOT_ALLOWED;
}
