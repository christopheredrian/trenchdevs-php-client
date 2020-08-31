<?php

namespace TrenchDevs\TrenchDevsClient;

require 'vendor/autoload.php';

class Endpoints
{
    const TEST = 'api/test';
    const ME = 'api/me';
    const LOGIN = 'api/login';
    const LOGOUT = 'api/logout';
    const REGISTER = 'api/register';

    // products
    const PRODUCTS_GET = 'api/products';
    const PRODUCTS_GET_ONE = 'api/products/%s';
}
