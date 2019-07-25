<?php
declare(strict_types=1);
namespace App\Models;

use App\Core\Model;
use Exception;
use PDO;
use PDOStatement;

/**
 * Class OrderProduct
 *
 * @package App\Models
 * @property Product $product
 * @property Order $order
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
     * Getter for unknown attributes
     *
     * @param string $name
     * @return array|null
     */
    public function __get(string $name)
    {
        if ($name === 'product') {
            return $this->relationProduct();
        } elseif ($name === 'order') {
            return $this->relationOrder();
        }

        return null;
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

    /**
     * Get relation one-to-one of Product
     *
     * @return array|null
     */
    public function relationProduct(): ?Product
    {
        try {
            /** @var Product $product */
            $product = new Product;
            /** @var PDOStatement $sql */
            $sql = db()->getPdo()->prepare("SELECT * FROM `{$product->getTable()}` WHERE `id` = :product_id");
            if ($sql && $sql->execute(['product_id' => $this->product_id])) {
                $items = $sql->fetchAll(PDO::FETCH_CLASS, Product::class);
                return count($items) ? $items[0] : null;
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get relation one-to-one of Order
     *
     * @return array|null
     */
    public function relationOrder(): ?Order
    {
        try {
            /** @var Order $order */
            $order = new Order;
            /** @var PDOStatement $sql */
            $sql = db()->getPdo()->prepare("SELECT * FROM `{$order->getTable()}` WHERE `id` = :order_id");
            if ($sql && $sql->execute(['order_id' => $this->order_id])) {
                $items = $sql->fetchAll(PDO::FETCH_CLASS, Order::class);
                return count($items) ? $items[0] : null;
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }
}
