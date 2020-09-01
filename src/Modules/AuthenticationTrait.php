<?php

namespace TrenchDevs\TrenchDevsClient\Modules;

use TrenchDevs\TrenchDevsClient\Endpoints;
use TrenchDevs\TrenchDevsClient\TrenchDevsGuzzleClient;

trait AuthenticationTrait
{
    /**
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function login(string $email, string $password)
    {
        $response = $this->postForm(Endpoints::LOGIN, [
            'email' => $email,
            'password' => $password,
        ]);

        $accessToken = $response->access_token ?? $response['access_token'] ?? null;

        if (!empty($accessToken)) {
            $this->client = TrenchDevsGuzzleClient::setClient($this->apiEndpoint, [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ]);
        }

        return $response;
    }

    public function register($userDetails = [])
    {
        return $this->postForm(Endpoints::REGISTER, $userDetails);
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        return $this->postForm(Endpoints::LOGOUT);
    }

    /**
     * @return object
     */
    public function me()
    {
        return $this->postForm(Endpoints::ME);
    }

}