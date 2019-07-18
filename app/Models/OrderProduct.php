<?php
declare(strict_types=1);
namespace Models;

use Core\Model;
use Exception;

/**
 * Class OrderProduct
 *
 * @package Models
 */
class OrderProduct extends Model
{
    /** @var string $table */
    protected $table = 'order_products';

    /** @var int $id */
    public $id;
    /** @var int $order_id */
    public $order_id;
    /** @var int $product_id */
    public $product_id;
    /** @var \DateTime|string */
    public $created_at;

    /**
     * OrderProduct constructor.
     */
    public function __construct()
    {
        $this->id = (int)$this->id;
        $this->order_id = (int)$this->order_id;
        $this->product_id = (int)$this->product_id;
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
                        `{$this->table}` (order_id, product_id, created_at) 
                    VALUES (:order_id, :product_id, :created_at)
                ",
                [
                    'order_id'      => $params['order_id'] ?? null,
                    'product_id'    => $params['product_id'] ?? null,
                    'created_at'    => date('Y-m-d H:i:s'),
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
                        SET order_id = :order_id, product_id = :product_id, created_at = :created_at 
                    WHERE id = :id
                ",
                [
                    'id'            => $id,
                    'order_id'      => $params['order_id'] ?? null,
                    'product_id'    => $params['product_id'] ?? null,
                    'created_at'    => $params['created_at'] ?? date('Y-m-d H:i:s'),
                ]
            );
        } catch (Exception $e) {
            return ['id' => null, 'error' => $e->getMessage()];
        }
    }
}
