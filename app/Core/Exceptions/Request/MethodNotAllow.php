<?php
declare(strict_types=1);
namespace App\Core\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class MethodNotAllow
 *
 * @package App\Core\Exceptions
 */
class MethodNotAllow extends CoreException
{
    /** @var string $message */
    protected $message = 'Method now allowed.';
    /** @var int $code */
    protected $code = Response::HTTP_METHOD_NOT_ALLOWED;
}
