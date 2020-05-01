<?php

namespace IPinchuk\YandexTaxi\Api;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Car
 *
 * Gets a list of cars in the park.
 *
 * @link https://fleet.taxi.yandex.ru/api/docs/reference/Cars.html
 *
 * @package IPinchuk\YandexTaxi\Api
 *
 * @author Igor Pinchuk <ipinchuk.developer@gmail.com>
 */
class Car extends AbstractApi {

    /**
     * Gets a list of cars in the park.
     *
     * @param array $fields
     * @param array $query
     * @param int $page
     * @param int $limit
     *
     * @return GuzzleException|ResponseInterface
     */
    public function all($fields = [], $query = [], $page = 1, $limit = 1000)
    {
        $params = [
            'offset' => ($page - 1) * $limit,
            'limit' => $limit,
            'query' => $this->prepareQuery($query)
        ];

        if ($fields) {
            $params['fields'] = $fields;
        }

        return $this->post('parks/cars/list', $params);
    }

}