<?php
declare(strict_types=1);
namespace Services;

use Core\{Database, Response, Service};
use Exception;
use Exceptions\Handler;
use Models\{Order, Product, User};
use PDO;
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
            /** @var array[Product] $products */
            $products = $this->getProductsForOrder($params['product_ids']);

            try {
                ['id' => $orderId, 'error' => $error] = (new Order)->create([
                    'user_id'    => (new User)->id,
                    'status'     => Order::STATUS_NEW,
                ]);

                if ($error) {
                    throw new Exception($error);
                }

                $sum = 0;
                foreach ($products as $product) {
                    /** @var Product $product */
                    ['error' => $error] = $product->createOrderProduct($orderId);
                    if ($error) {
                        throw new Exception($error);
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
                ['item' => $order, 'error' => $error] = (new Order())->show($orderId);

                if ($error) {
                    throw new Exception($error);
                }

                if ($order->status !== Order::STATUS_NEW) {
                    throw new Exception('System error: status of order should be `new`.');
                }

                if (!$order->checkSum($orderSum)) {
                    throw new Exception('System error: sum of order does not match.');
                }

                if (!$this->checkGateway(GATEWAY_URL)) {
                    throw new Exception('System error: gateway is not available.');
                }

                ['error' => $error] = $order->edit($order->id, [
                    'user_id'       => $order->user_id,
                    'status'        => Order::STATUS_PAID,
                    'created_at'    => $order->created_at,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);

                if ($error) {
                    throw new Exception('System error: cannot update status for order.');
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
            $product = new Product;
            $whereIn = str_repeat('?,', count($productsIds) - 1) . '?';

            /** @var PDOStatement $sql */
            $sql = (Database::getInstance())
                ->prepare("SELECT * FROM `{$product->getTable()}` WHERE `id` IN ({$whereIn})");
            if ($sql && $sql->execute($productsIds)) {
                /** @var array[Product] $products */
                $products = $sql->fetchAll(PDO::FETCH_CLASS, Product::class);
                if (!count($products)) {
                    throw new Exception(
                        'Bad request data: invalid `product_ids` values.',
                        \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
                    );
                }
                return $products;
            }
            throw new Exception('Database error: cannot check `product_ids`.');
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
        return $httpCode === 200;
    }
}
