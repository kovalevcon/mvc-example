<?php
declare(strict_types=1);
namespace App\Core\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotFoundRoute
 *
 * @package App\Core\Exceptions
 */
class NotFoundRoute extends CoreException
{
    /** @var string $message */
    protected $message = 'Not found route.';
    /** @var int $code */
    protected $code = Response::HTTP_NOT_FOUND;
}
