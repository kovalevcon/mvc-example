<?php
declare(strict_types=1);
namespace Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotEnoughRouterParameters
 *
 * @package Exceptions
 */
class NotEnoughRouterParameters extends Exception
{
    /** @var string $message */
    protected $message = 'Not enough router parameters.';
    /** @var int $code */
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
}
