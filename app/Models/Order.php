<?php
declare(strict_types=1);
namespace App\Models;

use App\Core\Model;
use Exception;
use PDO;
use PDOStatement;

/**
 * Class Order
 *
 * @package App\Models
 * @property array $orderProducts
 */
class Order extends Model
{
    const
        STATUS_NEW  = 'new',
        STATUS_PAID = 'paid'
    ;

    /** @var string $table */
    protected $table = 'orders';

    /** @var int $id */
    public $id;
    /** @var int $user_id */
    public $user_id;
    /**
     * Maybe `new` or `paid`
     * @var string $status
     */
    public $status;
    /** @var \DateTime|string */
    public $created_at;
    /** @var \DateTime|string|null */
    public $updated_at;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->id = (int)$this->id;
    }

    /**
     * Getter for unknown attributes
     *
     * @param string $name
     * @return array|null
     */
    public function __get(string $name)
    {
        if ($name === 'orderProducts') {
            return $this->relationOrderProducts();
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
                        `{$this->table}` (user_id, status, created_at, updated_at) 
                    VALUES (:user_id, :status, :created_at, :updated_at)
                ",
                [
                    'user_id'       => $params['user_id'] ?? null,
                    'status'        => $params['status'] ?? null,
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
                        SET user_id = :user_id, status = :status, created_at = :created_at, updated_at = :updated_at 
                    WHERE id = :id
                ",
                [
                    'id'            => $id,
                    'user_id'       => $params['user_id'] ?? null,
                    'status'        => $params['status'] ?? null,
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
     * @param int $productId
     * @return array
     */
    public function createOrderProduct(int $productId): array
    {
        return (new OrderProduct)->create([
            'order_id'      => $this->id,
            'product_id'    => $productId,
        ]);
    }

    /**
     * Get relation one-to-many of OrderProducts
     *
     * @return array|null
     */
    public function relationOrderProducts(): ?array
    {
        try {
            /** @var OrderProduct $orderProduct */
            $orderProduct = new OrderProduct;
            /** @var PDOStatement $sql */
            $sql = db()->getPdo()->prepare("SELECT * FROM `{$orderProduct->getTable()}` WHERE `order_id` = :order_id");
            if ($sql && $sql->execute(['order_id' => $this->id])) {
                $items = $sql->fetchAll(PDO::FETCH_CLASS, OrderProduct::class);
                return count($items) ? $items : null;
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Calculate sum of order
     *
     * @return float
     */
    public function calculateSum(): float
    {
        $sum = 0.0000;
        foreach ($this->orderProducts as $orderProduct) {
            /** @var OrderProduct $orderProduct */
            if ($orderProduct->product) {
                $sum += $orderProduct->product->cost;
            }
        }
        return $sum;
    }

    /**
     * Check sum of order
     *
     * @param float $sum
     * @return bool
     */
    public function checkSum(float $sum): bool
    {
        return $sum === $this->calculateSum();
    }
}
