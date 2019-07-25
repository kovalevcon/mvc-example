<?php
declare(strict_types=1);
namespace App\Core\Database;

use PDO;

/**
 * Class Database
 *
 * @package App\Core
 */
class Database
{
    /** @var PDO $pdo */
    private $pdo;

    /**
     * Database constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get PDO connection
     *
     * @return PDO
     * @deprecated
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
