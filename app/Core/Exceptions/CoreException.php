<?php
declare(strict_types=1);
namespace App\Core\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CoreException
 *
 * @package App\Core\Exceptions
 */
class CoreException extends Exception
{
    /** @var string $message */
    protected $message = 'System error: internal server error.';
    /** @var int $code */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
