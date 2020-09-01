<?php

/**
 * Configuration:
 *
 *  Ensure that you have a .env file setup on local (copy and modify .env.example) before running
 *
 * To run:
 *
 *  php examples/Example.php
 */
use TrenchDevs\TrenchDevsClient\TrenchDevsClient;

require 'vendor/autoload.php';
require_once 'utilities.php';

try {

    /**
     * Setup environment variables
     */
    $endpoint = env('API_ENDPOINT', 'http://trenchdevs.test');
    $email = env('USER_EMAIL');
    $password = env('USER_PASSWORD');
    $productId = env('PRODUCT_ID');

    allWithValuesOrThrow([$endpoint, $email, $password, $productId]);

    // Initiate client
    $trenchDevsClient = new TrenchDevsClient($endpoint);

    // By default - all responses are in object format (stdClass), set to true if you preferred using array
    // $trenchDevsClient->setAssociateArrayResponse(true);

    // Send a test route
    print_json($trenchDevsClient->test());

    // Puthenticate
    print_json($trenchDevsClient->login($email, $password));
    print_json($trenchDevsClient->me());

    // Products api
    print_json($trenchDevsClient->products());
    print_json($trenchDevsClient->productOne($productId));

    // Logout client
    print_json($trenchDevsClient->logout());

} catch (Exception $exception) {
    echoln($exception->getMessage());
}
