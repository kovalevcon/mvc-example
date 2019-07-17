<?php
declare(strict_types=1);
namespace Core;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Response
 *
 * @package Core
 */
class Response implements ResponseJsonable
{
    /** @var array $structure */
    public static $structure = [
        'success' => null,
        'payload' => null,
        'error'   => null,
    ];

    /**
     * @inheritDoc
     */
    public static function errorResponse(Exception $exception): JsonResponse
    {
        $structure = array_merge(self::$structure, [
            'success' => false,
            'error'   => [
                'code'      => $exception->getCode(),
                'message'   => $exception->getMessage(),
            ]
        ]);
        return (JsonResponse::create($structure, $exception->getCode()))->send();
    }

    /**
     * @inheritDoc
     */
    public static function successResponse($payload): JsonResponse
    {
        $structure = array_merge(self::$structure, [
            'success' => true,
            'payload' => $payload
        ]);
        return (JsonResponse::create($structure, \Symfony\Component\HttpFoundation\Response::HTTP_OK))->send();
    }
}
