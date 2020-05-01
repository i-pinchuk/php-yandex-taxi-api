<?php

namespace IPinchuk\YandexTaxi\Api;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DriverProfile
 *
 * Gets a list of driver profiles in the park. Adds and Removes driver profile association with vehicle
 *
 * @link https://fleet.taxi.yandex.ru/api/docs/reference/DriverProfiles.html
 *
 * @package IPinchuk\YandexTaxi\Api
 *
 * @author Igor Pinchuk <ipinchuk.developer@gmail.com>
 */
class DriverProfile extends AbstractApi {

    /**
     * Gets a list of driver profiles in the park.
     *
     * @param array $fields
     * @param array $query
     * @param array $sort_order
     * @param int $page
     * @param int $limit
     *
     * @return GuzzleException|ResponseInterface
     */
    public function all($fields = [], $query = [], $sort_order = [], $page = 1, $limit = 1000)
    {
        $params = [
            'offset' => ($page - 1) * $limit,
            'limit' => $limit,
            'query' => $this->prepareQuery($query),
            'sort_order' => $sort_order
        ];

        if ($fields) {
            $params['fields'] = $fields;
        }

        return $this->post('parks/driver-profiles/list', $params);
    }

    /**
     * Changes the association of the driver profile with the car
     *
     * @param $profile_id
     * @param $car_id
     *
     * @return mixed
     */
    public function bindVehicle($profile_id, $car_id)
    {
        $params = [
            'park_id' => $this->client->getParkId(),
            'driver_profile_id' => $profile_id,
            'car_id' => $car_id
        ];

        return $this->put('parks/driver-profiles/car-bindings', $params);
    }

    /**
     * Removes driver profile association with vehicle
     *
     * @param $profile_id
     * @param $car_id
     *
     * @return mixed
     */
    public function unbindVehicle($profile_id, $car_id)
    {
        $params = [
            'park_id' => $this->client->getParkId(),
            'driver_profile_id' => $profile_id,
            'car_id' => $car_id
        ];

        return $this->delete('parks/driver-profiles/car-bindings', $params);
    }
}