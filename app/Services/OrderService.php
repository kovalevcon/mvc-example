<?php
declare(strict_types=1);
namespace Services;

use Core\{Database, Response, Service};
use Exception;
use Exceptions\{Handler, OrderException};
use Models\{ModelFactory, Order, Product, User};
use PDO;
use PDOException;
use PDOStatement;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class OrderService
 *
 * @package Services
 */
class OrderService extends Service implements OrderServiceRepository
{
    /**
     * @inheritDoc
     */
    public function createOrder(array $params): JsonResponse
    {
        try {
            $this->validateCreateOrder($params);
            /** @var array $products */
            $products = $this->getProductsForOrder($params['product_ids']);

            try {
                ['id' => $orderId, 'error' => $error] = ModelFactory::make(Order::class)->create([
                    'user_id'    => (new User)->id,
                    'status'     => Order::STATUS_NEW,
                ]);

                if ($error) {
                    throw new OrderException($error);
                }

                $sum = 0;
                foreach ($products as $product) {
                    /** @var Product $product */
                    ['error' => $error] = $product->createOrderProduct($orderId);
                    if ($error) {
                        throw new OrderException($error);
                    }
                    $sum += $product->cost;
                }
                return Response::successResponse(['id' => $orderId, 'sum' => $sum]);
            } catch (Exception $e) {
                Handler::handle($e);
            }
        } catch (Exception $e) {
            return Response::errorResponse($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function payOrder(array $params): JsonResponse
    {
        try {
            $this->validatePayOrder($params);

            try {
                ['id' => $orderId, 'sum' => $orderSum] = $params;
                /** @var Order $order */
                ['item' => $order, 'error' => $error] = ModelFactory::make(Order::class)->show($orderId);

                if ($error) {
                    throw new OrderException($error);
                }

                if ($order->status !== Order::STATUS_NEW) {
                    throw new OrderException('Order error: status of order should be `new`.');
                }

                if (!$order->checkSum($orderSum)) {
                    throw new OrderException('Order error: sum of order does not match.');
                }

                if (!$this->checkGateway(GATEWAY_URL)) {
                    throw new OrderException('Order error: gateway is not available.');
                }

                ['error' => $error] = $order->edit($order->id, [
                    'user_id'       => $order->user_id,
                    'status'        => Order::STATUS_PAID,
                    'created_at'    => $order->created_at,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);

                if ($error) {
                    throw new OrderException('Order error: cannot update status for order.');
                }
                return Response::successResponse(['id' => $orderId, 'status' => Order::STATUS_PAID]);
            } catch (Exception $e) {
                Handler::handle($e);
            }
        } catch (Exception $e) {
            return Response::errorResponse($e);
        }
    }

    /**
     * Validate params for createOrder method
     *
     * @param array $params
     * @throws \Exception
     */
    private function validateCreateOrder(array $params): void
    {
        if (!array_key_exists('product_ids', $params) || !is_array($params['product_ids'])
            || !count($params['product_ids'])) {
            Handler::handle(
                new Exception(
                    'Required field `products` is missed or have invalid data.',
                    \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
                )
            );
        }
    }

    /**
     * Validate params for payOrder method
     *
     * @param array $params
     * @throws \Exception
     */
    private function validatePayOrder(array $params): void
    {
        if (!array_key_exists('id', $params) || !is_int($params['id'])
            || !array_key_exists('sum', $params) || !is_float($params['sum'])) {
            Handler::handle(
                new Exception(
                    'Required fields `id` or `sum` is missed or have invalid data.',
                    \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
                )
            );
        }
    }

    /**
     * Get array of Product models
     *
     * @param array $productsIds
     * @return array
     * @throws \Exception
     */
    private function getProductsForOrder(array $productsIds): array
    {
        try {
            /** @var Product $product */
            $product = ModelFactory::make(Product::class);
            $whereIn = str_repeat('?,', count($productsIds) - 1) . '?';

            /** @var PDOStatement $sql */
            $sql = (Database::getInstance())
                ->prepare("SELECT * FROM `{$product->getTable()}` WHERE `id` IN ({$whereIn})");
            if ($sql && $sql->execute($productsIds)) {
                /** @var array $products */
                $products = $sql->fetchAll(PDO::FETCH_CLASS, Product::class);
                if (!count($products)) {
                    throw new OrderException(
                        'Order error: invalid `product_ids` values.',
                        \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
                    );
                }
                return $products;
            }
            throw new PDOException('Database error: not found rows by selected conditions.');
        } catch (Exception $e) {
            Handler::handle($e);
        }
    }

    /**
     * Check is available gateway
     *
     * @param string $gateway
     * @return bool
     */
    private function checkGateway(string $gateway): bool
    {
        /** @var resource $curl */
        $curl = curl_init($gateway);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $httpCode === \Symfony\Component\HttpFoundation\Response::HTTP_OK;
    }
}
