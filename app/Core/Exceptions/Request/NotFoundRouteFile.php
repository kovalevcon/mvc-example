<?php
declare(strict_types=1);
namespace App\Core\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotFoundRouteFile
 *
 * @package App\Core\Exceptions
 */
class NotFoundRouteFile extends CoreException
{
    /** @var string $message */
    protected $message = 'Not found routes file.';
    /** @var int $code */
    protected $code = Response::HTTP_NOT_FOUND;
}
