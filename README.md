# trenchdevs-php-client

A simple PHP client for the [trenchdevs.org](https://trenchdevs.org) API 

## Installation 

Package can be installed via composer

```
composer require trenchdevs/trenchdevs-php-client
```

## Basic Usage

```php

use TrenchDevs\TrenchDevsClient\TrenchDevsClient;

require __DIR__.'/vendor/autoload.php';

// Initiate client
$trenchDevsClient = new TrenchDevsClient('http://trenchdevs.test');

// By default - all responses are in object format (stdClass), set to true if you preferred using array
// $trenchDevsClient->setAssociateArrayResponse(true);

// Send a test route
var_dump($trenchDevsClient->test());

// Authenticate
var_dump($trenchDevsClient->login('...', '...'));
var_dump($trenchDevsClient->me());

// Products api
var_dump($trenchDevsClient->products());
var_dump($trenchDevsClient->productOne(6));

// Logout client
var_dump($trenchDevsClient->logout());

```

## Docs

todo

## Contributors

## License

The MIT License (MIT)

