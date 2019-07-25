<?php
declare(strict_types=1);
namespace App\Core\Traits;

/**
 * Trait Singleton
 *
 * @package App\Core\Traits
 */
trait Singleton
{
    private static $instance;

    /**
     * Database constructor.
     */
    private function __construct()
    {
        // Hide constructor
    }

    /**
     * Clone method for Database
     */
    private function __clone()
    {
        // Disable clone
    }

    /**
     * Wakeup method for Database
     */
    private function __wakeup()
    {
        // Disable deserialization
    }

    /**
     * Get instance of class
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        if (method_exists(self::$instance, 'config')) {
            self::$instance->config();
        }

        return self::$instance;
    }
}