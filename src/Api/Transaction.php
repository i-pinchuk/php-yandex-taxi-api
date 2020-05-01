<?php

namespace IPinchuk\YandexTaxi\Api;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Transaction
 *
 * Gets a list of transaction list in the park. Creates and modifies a driver transaction
 *
 * @link https://fleet.taxi.yandex.ru/api/docs/reference/Transactions.html
 *
 * @package IPinchuk\YandexTaxi\Api
 *
 * @author Igor Pinchuk <ipinchuk.developer@gmail.com>
 */
class Transaction extends AbstractApi {

    /**
     * @var string
     */
    protected $apiVersion = 'v2';

    /**
     * Gets a list of transaction list in the park.
     *
     * @param array $query
     * @param null $cursor
     * @param int $limit
     *
     * @return GuzzleException|ResponseInterface
     */
    public function all($query = [], $cursor = null, $limit = 1000)
    {
        $params = [
            'query' => $this->prepareQuery($query),
            'cursor' => $cursor
        ];

        return $this->post('parks/transactions/list', $params);
    }

    /**
     * Gets a list of transaction categories in the park
     *
     * @param array $query
     *
     * @return GuzzleException|ResponseInterface
     */
    public function categories($query = [])
    {
        $params = [
            'query' => parent::prepareQuery($query),
        ];

        return $this->post('parks/transactions/categories/list', $params);
    }

    /**
     * Gets a list of transactions for an driver in the park
     *
     * @param $driver_id
     * @param array $query
     * @param string $cursor
     * @param int $limit
     *
     * @return GuzzleException|ResponseInterface
     */
    public function driverTransactions($driver_id, array $query = [], $cursor = '', $limit = 1000)
    {
        $query['park']['driver_profile']['id'] = $driver_id;

        $params = [
            'limit' => $limit,
            'cursor' => $cursor,
            'query' => $this->prepareQuery($query),
        ];

        return $this->post('parks/driver-profiles/transactions/list', $params);
    }

    /**
     * Gets a list of transactions for orders in the park
     *
     * @param array $order_ids
     * @param array $query
     *
     * @return GuzzleException|ResponseInterface
     */
    public function orderTransactions(array $order_ids, array $query = [])
    {
        $query['park']['order']['ids'] = $order_ids;

        $params = [
            'query' => parent::prepareQuery($query),
        ];

        return $this->post('parks/orders/transactions/list', $params);
    }

    /**
     * Creates a driver transaction
     *
     * @param $driver_id
     * @param $amount
     * @param $cat_id
     * @param $description
     *
     * @return GuzzleException|ResponseInterface
     */
    public function createTransaction($driver_id, $amount, $cat_id, $description)
    {
        $params = [
            'park_id' => $this->client->getParkId(),
            'driver_profile_id' => $driver_id,
            'category_id' => $cat_id,
            'amount' => $amount,
            'description' => $description
        ];

        return $this->post('parks/driver-profiles/transactions', $params);
    }

    /**
     * Increases driver amount on the $amount
     *
     * @param $driver_id
     * @param $amount
     * @param $cat_id
     * @param $description
     *
     * @return GuzzleException|ResponseInterface
     */
    public function increaseBalance($driver_id, $amount, $cat_id, $description)
    {
        $amount = abs($amount);

        return $this->createTransaction($driver_id, (string) $amount, $cat_id, $description);
    }

    /**
     * Decreases driver amount on the $amount
     *
     * @param $driver_id
     * @param $amount
     * @param $cat_id
     * @param $description
     *
     * @return GuzzleException|ResponseInterface
     */
    public function decreaseBalance($driver_id, $amount, $cat_id, $description)
    {
        $amount = -1 * abs($amount);

        return $this->createTransaction($driver_id, (string) $amount, $cat_id, $description);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    protected function prepareQuery($query)
    {
        $query = parent::prepareQuery($query);

        if (!isset($query['park']['transaction']['event_at'])) {
            $query['park']['transaction']['event_at'] = [
                'from' => date('c', strtotime('-1 day')),
                'to' => date('c')
            ];
        }

        return $query;
    }

}