<?php
declare(strict_types=1);
namespace Core;

use Exceptions\Handler;
use PDO;
use PDOException;

/**
 * Class Database
 *
 * @package Core
 */
final class Database
{
    /** @var PDO $instance */
    private static $instance;

    /**
     * Database constructor.
     */
    private function __construct()
    {
        // Hide constructor
    }

    /**
     * Get instance of connect to DB
     *
     * @return PDO
     * @throws \Exception
     */
    public static function getInstance(): PDO
    {
        if (!self::$instance) {
            try {
                self::$instance = new PDO(
                    sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME),
                    DB_USERNAME,
                    DB_PASSWORD
                );
            } catch (PDOException $e) {
                Handler::handle($e);
            }

        }

        return self::$instance;
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
}
