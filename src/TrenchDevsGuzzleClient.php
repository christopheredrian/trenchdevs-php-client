<?php

namespace TrenchDevs\TrenchDevsClient;

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class TrenchDevsGuzzleClient
{
    /**
     * @var Client
     */
    private static $guzzleClient = null;

    /**
     * @param string $apiEndpoint
     * @param array $headers
     * @return Client
     */
    public static function getClient(string $apiEndpoint, array $headers = []): Client
    {

        if (!empty(self::$guzzleClient)) {
            return self::$guzzleClient;
        }

        self::setClient($apiEndpoint, $headers);
        return self::$guzzleClient;
    }

    /**
     * @param string $apiEndpoint
     * @param array $headers
     * @return Client
     */
    public static function setClient(string $apiEndpoint, array $headers = [])
    {
        $defaultHeaders = [
            // todo: On Back-end get from secret & token instead, this is insecure
            'x-account-id' => 1
        ];

        $options = [
            // Base URI is used with relative requests
            'base_uri' => $apiEndpoint,
            'timeout' => 60,
            'headers' => $defaultHeaders,
        ];


        if (!empty($headers)) {
            $options['headers'] = array_merge($defaultHeaders, $headers);
        }

        return self::$guzzleClient = new Client($options);
    }
}