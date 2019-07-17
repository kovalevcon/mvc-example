<?php
declare(strict_types=1);
namespace Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PDOErrorException
 *
 * @package Exceptions
 */
class PDOErrorException extends Exception
{
    /** @var string $message */
    protected $message = 'Error while connection to PDO.';
    /** @var int $code */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
