<?php
declare(strict_types=1);
namespace Core;

use Exception;
use Exceptions\Handler;

/**
 * Trait RequestUtils
 *
 * @package Core
 */
trait RequestUtils
{
    /**
     * Safety user data from XSS attack
     *
     * @param array $data
     * @return array
     * @throws Exception
     */
    protected function safetyUserData($data)
    {
        if (!is_array($data)) {
            Handler::handle(new Exception(
                'Bad request: invalid JSON data.',
                \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
            ));
        }

        return array_map(function ($var) {
            if (is_array($var)) {
                return $this->safetyUserData($var);
            }
            return is_string($var) ? htmlentities($var) : $var;
        }, $data);
    }
}
