<?php
declare(strict_types=1);
namespace App\Core\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ControllerException
 *
 * @package App\Core\Exceptions
 */
class ControllerException extends Exception
{
    /** @var string $message */
    protected $message = 'System error: internal server error in controller.';
    /** @var int $code */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
