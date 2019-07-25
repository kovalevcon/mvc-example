<?php
declare(strict_types=1);
namespace App\Core\Database;

use App\Core\Exceptions\Handler;
use App\Core\Traits\Singleton;
use PDO;
use PDOException;

/**
 * Class PDOConnection
 *
 * @package App\Core\Database
 */
final class PDOConnection
{
    use Singleton;

    /**
     * Get instance of connect to DB
     *
     * @param \stdClass $dbConfig
     * @return PDO
     * @throws \Exception
     */
    public static function getInstance($dbConfig): PDO
    {
        if (!self::$instance) {
            try {
                $driver = $dbConfig->connections->{$dbConfig->driver};

                self::$instance = new PDO(
                    "{$dbConfig->driver}:host={$driver->host};dbname={$driver->database}",
                    $driver->username,
                    $driver->password
                );
            } catch (PDOException $e) {
                Handler::handle($e);
            }

        }

        return self::$instance;
    }
}
