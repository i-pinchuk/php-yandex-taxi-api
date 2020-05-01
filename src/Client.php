<?php

namespace IPinchuk\YandexTaxi;

use http\Exception\InvalidArgumentException;

class Client {

    /**
     *  Base API url
     */
    const API_URL = "https://fleet-api.taxi.yandex.net";

    /**
     * Yandex client ID
     *
     * @var string
     */
    private $clientId;

    /**
     * Yandex API key
     *
     * @var string
     */
    private $apiKey;

    /**
     * Yandex park ID
     *
     * @var string
     */
    private $parkId;

    /**
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $proxy;

    /**
     * Client constructor.
     *
     * @param $clientId
     * @param $apiKey
     * @param $parkId
     */
    public function __construct($clientId, $apiKey, $parkId)
    {
        $this->clientId = $clientId;
        $this->apiKey = $apiKey;
        $this->parkId = $parkId;
    }

    /**
     * @param $apiVersion string
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient($apiVersion)
    {
        if (!$this->httpClient) {
            $url = self::API_URL . '/' . $apiVersion . '/';
            $apiKey = $this->getApiKey();

            $this->httpClient = new \GuzzleHttp\Client([
                'base_uri' => $url,
                'headers' => [
                    'X-Client-ID' => $this->getClientId(),
                    'X-Api-Key' => $apiKey,
                    'X-Idempotency-Token' => md5($apiKey . time())
                ],
                'proxy' => $this->getProxy()
            ]);
        }
        return $this->httpClient;
    }

    /**
     * @param $name
     *
     * @return \IPinchuk\YandexTaxi\Api\Car|\IPinchuk\YandexTaxi\Api\DriverProfile|\IPinchuk\YandexTaxi\Api\DriverWorkRule|\IPinchuk\YandexTaxi\Api\Order|\IPinchuk\YandexTaxi\Api\Transaction
     */
    public function api($name)
    {
        switch($name) {
            case 'cars':
                $api = new Api\Car($this);
                break;

            case 'drivers':
                $api = new Api\DriverProfile($this);
                break;

            case  'rules':
                $api = new Api\DriverWorkRule($this);
                break;

            case 'orders':
                $api = new Api\Order($this);
                break;

            case 'transactions':
                $api = new Api\Transaction($this);
                break;

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * Create new object
     *
     * @return \IPinchuk\YandexTaxi\Api\Car
     */
    public function cars()
    {
        return new Api\Car($this);
    }

    /**
     * Create new object
     *
     * @return \IPinchuk\YandexTaxi\Api\DriverProfile
     */
    public function drivers()
    {
        return new Api\DriverProfile($this);
    }

    /**
     * Create new object
     *
     * @return \IPinchuk\YandexTaxi\Api\DriverWorkRule
     */
    public function rules()
    {
        return new Api\DriverWorkRule($this);
    }

    /**
     * Create new object
     *
     * @return \IPinchuk\YandexTaxi\Api\Order
     */
    public function orders()
    {
        return new Api\Order($this);
    }

    /**
     * Create new object
     *
     * @return \IPinchuk\YandexTaxi\Api\Transaction
     */
    public function transactions()
    {
        return new Api\Transaction($this);
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getParkId()
    {
        return $this->parkId;
    }

    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param $proxy string
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

}