<?php
declare(strict_types=1);
namespace App\Core;

use App\Core\Interfaces\ModelRepository;
use Exception;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Class Model
 *
 * @package App\Core
 */
abstract class Model implements ModelRepository
{
    /** @var string $table */
    protected $table;

    /**
     * @inheritDoc
     */
    abstract public function create(array $params): array;

    /**
     * @inheritDoc
     */
    abstract public function edit(int $id, array $params): array;

    /**
     * Get table name
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @inheritDoc
     */
    public function showAll(): array
    {
        try {
            /** @var PDOStatement $sql */
            $sql = db()->getPdo()->prepare("SELECT * FROM `{$this->table}`");
            if ($sql && $sql->execute()) {
                return ['items' => $sql->fetchAll(PDO::FETCH_CLASS, static::class), 'error' => null];
            }
            throw new PDOException('Database error: while get all rows from table.');
        } catch (Exception $e) {
            return ['items' => null, 'error' => $e->getMessage()];
        }
    }

    /**
     * @inheritDoc
     */
    public function show(int $id): array
    {
        try {
            /** @var PDOStatement $sql */
            $sql = db()->getPdo()->prepare("SELECT * FROM `{$this->table}` WHERE `id` = :id");
            if ($sql && $sql->execute(['id' => $id])) {
                $items = $sql->fetchAll(PDO::FETCH_CLASS, static::class);
                if (!count($items)) {
                    throw new PDOException('Database error: not found rows by selected conditions.');
                }
                return ['item' => $items[0], 'error' => null];
            }
            throw new PDOException('Database error: while get one row from table.');
        } catch (Exception $e) {
            return ['item' => null, 'error' => $e->getMessage()];
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): array
    {
        try {
            /** @var PDOStatement $sql */
            $sql = db()->getPdo()->prepare("DELETE FROM `{$this->table}` WHERE `id` = :id");
            if ($sql && $sql->execute(['id' => $id])) {
                return ['status' => true, 'error' => null];
            }
            throw new PDOException('Database error: while get one row from table.');
        } catch (Exception $e) {
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Execute query with data
     *
     * @param string $query
     * @param array  $data
     * @return array
     * @throws \Exception
     */
    protected function executeQuery(string $query, array $data): array
    {
        /** @var PDO $pdo */
        $pdo = db()->getPdo();
        $pdo->beginTransaction();
        try {
            /** @var PDOStatement $sql */
            $sql = $pdo->prepare($query);
            if ($sql && $sql->execute($data)) {
                $id = $data['id'] ?? $pdo->lastInsertId();
                $pdo->commit();
                return ['id' => (int)$id, 'error' => null];
            }
            throw new PDOException('Database error: while execute query from table.');
        } catch (Exception $e) {
            $pdo->rollBack();
            return ['id' => null, 'error' => $e->getMessage()];
        }
    }
}
