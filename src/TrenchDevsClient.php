<?php

namespace TrenchDevs\TrenchDevsClient;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use TrenchDevs\TrenchDevsClient\Modules\AuthenticationTrait;
use TrenchDevs\TrenchDevsClient\Modules\ProductsTrait;

class TrenchDevsClient
{
    use AuthenticationTrait;
    use ProductsTrait;

    /**
     * @var Client
     */
    private $client;

    /**
     * If true return responses as object
     * @var bool
     */
    private $associateArrayResponse = false;

    /**
     * @var string|null
     */
    private $apiEndpoint = null;

    /**
     * Default value on api exception or when unable to json decode
     * @var mixed
     */
    private $defaultValueOnException = null;

    /**
     * TrenchDevsConnector constructor.
     * @param string $apiEndpoint
     */
    public function __construct(string $apiEndpoint)
    {
        if (empty($apiEndpoint)) {
            throw new \InvalidArgumentException("api endpoint cannot be empty");
        }

        $this->apiEndpoint = $apiEndpoint;
        $this->client = \TrenchDevs\TrenchDevsClient\TrenchDevsGuzzleClient::getClient($this->apiEndpoint);
    }

    /**
     * @return mixed|null
     */
    public function test()
    {
        return $this->get(Endpoints::TEST);
    }

    /**
     * @param string $endpoint
     * @param array $formParams
     * @return mixed|null
     */
    public function postForm(string $endpoint, array $formParams = [])
    {
        $options = [];

        if (!empty($formParams)) {
            $options['form_params'] = $formParams;
        }

        return $this->callFunctionOrDefault(function () use ($endpoint, $options) {
            return $this->getContentsDecoded($this->client->post($endpoint, $options));
        });

    }

    /**
     * @param string $endpoint
     * @param array $endpointSprintfArgs
     * @return mixed|null
     */
    public function get(string $endpoint, $endpointSprintfArgs = [])
    {
        if (!empty($endpointSprintfArgs)) {
            $endpoint = call_user_func_array("sprintf", [$endpoint, $endpointSprintfArgs]);
        }

        return $this->callFunctionOrDefault(function () use ($endpoint) {
            return $this->getContentsDecoded($this->client->get($endpoint));
        });
    }

    /**
     * @param callable $toCall
     * @return mixed|null
     */
    private function callFunctionOrDefault(callable $toCall)
    {
        try {
            return $toCall();
        } catch (ClientException $exception) {
            return $this->decodeOrDefault($this->getContentsFromResponse($exception->getResponse()));
        } catch (\Exception $exception) {
            return $this->defaultValueOnException;
        }
    }


    /**
     * @param string $toDecode
     * @param null $default
     * @return mixed|null
     */
    private function decodeOrDefault(string $toDecode)
    {
        $decoded = json_decode($toDecode, $this->associateArrayResponse);

        if (json_last_error() == JSON_ERROR_NONE) {
            return $decoded;
        }

        return $this->defaultValueOnException;
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    private function getContentsFromResponse(ResponseInterface $response): string
    {
        return $response->getBody()->getContents();
    }

    /**
     * @param ResponseInterface $response
     * @return object|array|null
     */
    private function getContentsDecoded(ResponseInterface $response)
    {
        $response = $this->getContentsFromResponse($response);
        return json_decode($response, $this->associateArrayResponse);
    }

    /**
     * @param bool $associateArrayResponse
     * @return TrenchDevsClient
     */
    public function setAssociateArrayResponse(bool $associateArrayResponse): TrenchDevsClient
    {
        $this->associateArrayResponse = $associateArrayResponse;
        return $this;
    }

    /**
     * @param array $defaultValueOnException
     * @return TrenchDevsClient
     */
    public function setDefaultValueOnException(array $defaultValueOnException): TrenchDevsClient
    {
        $this->defaultValueOnException = $defaultValueOnException;
        return $this;
    }

}
