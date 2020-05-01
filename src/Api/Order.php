<?php

namespace IPinchuk\YandexTaxi\Api;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Order
 *
 * Gets a list of orders in the park.
 *
 * @link https://fleet.taxi.yandex.ru/api/docs/reference/Orders.html
 *
 * @package IPinchuk\YandexTaxi\Api
 *
 * @author Igor Pinchuk <ipinchuk.developer@gmail.com>
 */
class Order extends AbstractApi {

    /**
     * Gets a list of orders in the park.
     *
     * @param array $query
     * @param string $cursor
     * @param int $limit
     *
     * @return GuzzleException|ResponseInterface
     */
    public function all($query = [], $cursor = '', $limit = 500)
    {
        $params = [
            'limit' => $limit,
            'cursor' => $cursor,
            'query' => $this->prepareQuery($query)
        ];

        return $this->post('parks/orders/list', $params);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    protected function prepareQuery($query)
    {
        $query = parent::prepareQuery($query);

        if (!isset($query['park']['order']['booked_at']) &&
            !isset($query['park']['order']['ended_at'])) {
            $query['park']['order']['ended_at'] = [
                'from' => date('c', strtotime('-1 day')),
                'to' => date('c')
            ];
        }

        return $query;
    }
}