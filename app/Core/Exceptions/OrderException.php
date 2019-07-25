<?php
declare(strict_types=1);
namespace App\Core\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderException
 *
 * @package App\Core\Exceptions
 */
class OrderException extends CoreException
{
    /** @var string $message */
    protected $message = 'Order error: while work with order.';
    /** @var int $code */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;


}
