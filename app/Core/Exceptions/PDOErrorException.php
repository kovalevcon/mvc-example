<?php
declare(strict_types=1);
namespace App\Core\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class PDOErrorException
 *
 * @package App\Core\Exceptions
 */
class PDOErrorException extends CoreException
{
    /** @var string $message */
    protected $message = 'Database error: error while connection to PDO.';
    /** @var int $code */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
