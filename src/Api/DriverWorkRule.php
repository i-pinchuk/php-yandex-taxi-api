<?php

namespace IPinchuk\YandexTaxi\Api;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DriverWorkRule
 *
 * Gets a list of working rules.
 *
 * @link https://fleet.taxi.yandex.ru/api/docs/reference/DriverWorkRules.html
 *
 * @package IPinchuk\YandexTaxi\Api
 *
 * @author Igor Pinchuk <ipinchuk.developer@gmail.com>
 */
class DriverWorkRule extends AbstractApi {

    /**
     * Gets a list of working rules.
     *
     * @return GuzzleException|ResponseInterface
     */
    public function all()
    {
        $params = [
            'park_id' => $this->client->getParkId()
        ];

        return $this->get('parks/driver-work-rules', $params);
    }

}