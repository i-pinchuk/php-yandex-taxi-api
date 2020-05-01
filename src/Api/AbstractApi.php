<?php

namespace IPinchuk\YandexTaxi\Api;

use GuzzleHttp\Exception\GuzzleException;
use IPinchuk\YandexTaxi\Client as Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractApi
 *
 * @package IPinchuk\YandexTaxi\Api
 */
abstract class AbstractApi {

    /**
     * Yandex API version
     *
     * @var string
     */
    protected $apiVersion = 'v1';

    /**
     * The client
     *
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param $uri
     * @param array $params
     * @param array $headers
     *
     * @return GuzzleException|ResponseInterface
     */
    protected function get($uri, array $params = [], array $headers = [])
    {
        $http = $this->client->getHttpClient($this->apiVersion);

        if (count($params) > 0) {
            $uri .= '?' . http_build_query($params);
        }

        if ($headers) {
            $options['headers'] = $headers;
        }

        try {
            $response = $http->request('GET', $uri, $options);
        }
        catch(GuzzleException $e) {
            return $e;
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     *
     * @param $uri
     * @param array $params
     * @param array $headers
     *
     * @return GuzzleException|ResponseInterface
     */
    protected function post($uri, array $params, array $headers = [])
    {
        $http = $this->client->getHttpClient($this->apiVersion);

        $options = ['json' => $params];

        if ($headers) {
            $options['headers'] = $headers;
        }

        try {
            $response = $http->request('POST', $uri, $options);
        }
        catch(GuzzleException $e) {
            return $e;
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     *
     * @param $uri
     * @param array $params
     * @param array $headers
     *
     * @return GuzzleException|ResponseInterface
     */
    protected function put($uri, array $params, array $headers = [])
    {
        $http = $this->client->getHttpClient($this->apiVersion);

        if (count($params) > 0) {
            $uri .= '?' . http_build_query($params);
        }

        if ($headers) {
            $options['headers'] = $headers;
        }

        try {
            $response = $http->request('PUT', $uri, $options);
        }
        catch(GuzzleException $e) {
            return $e;
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param $uri
     * @param array $params
     * @param array $headers
     *
     * @return GuzzleException|ResponseInterface
     */
    protected function delete($uri, array $params, array $headers = [])
    {
        $http = $this->client->getHttpClient($this->apiVersion);

        if (count($params) > 0) {
            $uri .= '?' . http_build_query($params);
        }

        if ($headers) {
            $options['headers'] = $headers;
        }

        try {
            $response = $http->request('DELETE', $uri, $options);
        }
        catch(GuzzleException $e) {
            return $e;
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    protected function prepareQuery($query)
    {
        if (!isset($query['park']['id'])) {
            $query['park']['id'] = $this->client->getParkId();
        }

        return $query;
    }

}