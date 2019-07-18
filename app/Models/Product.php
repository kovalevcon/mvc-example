<?php
declare(strict_types=1);
namespace Models;

use Core\Model;
use Exception;

/**
 * Class Product
 *
 * @package Models
 */
class Product extends Model
{
    /** @var string $table */
    protected $table = 'products';

    /** @var int $id */
    public $id;
    /** @var string $name */
    public $name;
    /** @var float $cost */
    public $cost;
    /** @var \DateTime|string */
    public $created_at;
    /** @var \DateTime|string|null */
    public $updated_at;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->id = (int)$this->id;
        $this->cost = (float)$this->cost;
    }

    /**
     * @inheritDoc
     */
    public function create(array $params): array
    {
        try {
            return $this->executeQuery(
                "
                    INSERT INTO 
                        `{$this->table}` (name, cost, created_at, updated_at) 
                    VALUES (:name, :cost, :created_at, :updated_at)
                ",
                [
                    'name'          => $params['name'] ?? null,
                    'cost'          => $params['cost'] ?? null,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => null,
                ]
            );
        } catch (Exception $e) {
            return ['id' => null, 'error' => $e->getMessage()];
        }
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, array $params): array
    {
        try {
            return $this->executeQuery(
                "
                    UPDATE `{$this->table}`
                        SET name = :name, cost = :cost, created_at = :created_at, updated_at = :updated_at 
                    WHERE id = :id
                ",
                [
                    'id'            => $id,
                    'name'          => $params['name'] ?? null,
                    'cost'          => $params['cost'] ?? null,
                    'created_at'    => $params['created_at'] ?? date('Y-m-d H:i:s'),
                    'updated_at'    => $params['updated_at'] ?? date('Y-m-d H:i:s'),
                ]
            );
        } catch (Exception $e) {
            return ['id' => null, 'error' => $e->getMessage()];
        }
    }

    /**
     * Create order product
     *
     * @param int $orderId
     * @return array
     */
    public function createOrderProduct(int $orderId): array
    {
        return (new OrderProduct)->create([
            'order_id'      => $orderId,
            'product_id'    => $this->id,
        ]);
    }
}
