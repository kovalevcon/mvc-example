<?php
declare(strict_types=1);
namespace Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderException
 *
 * @package Exceptions
 */
class OrderException extends Exception
{
    /** @var string $message */
    protected $message = 'Order error: while work with order.';
    /** @var int $code */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
