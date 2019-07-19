<?php
declare(strict_types=1);
namespace Models;

use Core\Model;

/**
 * Class ModelFactory
 *
 * @package Models
 * @property array $orderProducts
 */
final class ModelFactory
{
    /**
     * Make instance of model by class name
     *
     * @param string $class
     * @return Model
     */
    public static function make(string $class): Model
    {
        return new $class;
    }
}
