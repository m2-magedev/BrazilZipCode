<?php

namespace MageDev\BrazilZipCode\Gateway;

use MageDev\BrazilZipCode\Helper\Config;
use Zend\Http\Client;

/**
 * Class AbstractRequest
 * @package MageDev\BrazilZipCode\Gateway
 */
abstract class AbstractRequest
{

    /** @var Client */
    protected $httpClient;

    /** @var Config */
    protected $config;

    /**
     * AbstractRequest constructor.
     * @param Client $httpClient
     * @param Config $configHelper
     */
    public function __construct(Client $httpClient, Config $configHelper)
    {
        $this->httpClient = $httpClient;
        $this->config = $configHelper;
    }

    /**
     * Post request
     * @param string $uri
     * @param string $rawBody
     * @param bool $isJson
     * @param null|string $apiKey
     * @return \Zend\Http\Response
     */
    protected function post($uri, $rawBody, $isJson = false, $apiKey = null)
    {
        $this->httpClient->setUri($uri);

        if ($rawBody) {
            $this->httpClient->setRawBody($rawBody);
        }

        $this->httpClient->setHeaders($this->getHeaders($isJson, $apiKey));
        $this->httpClient->setMethod("POST");
        return $this->httpClient->send();
    }

    /**
     * Get request
     * @param string $uri
     * @param bool $isJson
     * @param array $parameters
     * @param null|string $apiKey
     * @return \Zend\Http\Response
     */
    protected function get($uri, $isJson = false, $parameters = [], $apiKey = null)
    {
        $this->httpClient->setOptions(["timeout"=>1]);
        $this->httpClient->setUri($uri);
        $this->httpClient->setMethod("GET");
        if ($parameters) {
            $this->httpClient->setParameterGet($parameters);
        }

        $this->httpClient->setHeaders($this->getHeaders($isJson, $apiKey));

        return $this->httpClient->send();
    }

    /**
     * Get headers
     * @param bool $isJson
     * @param null $apiKey
     * @return array
     */
    private function getHeaders($isJson = false, $apiKey = null)
    {
        $headers = [];

        if ($isJson) {
            $headers["Content-Type"] = "application/json";
        }

        if ($apiKey) {
            $headers["Authorization"] = $apiKey;
        }

        return $headers;
    }
}