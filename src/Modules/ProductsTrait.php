<?php

namespace TrenchDevs\TrenchDevsClient\Modules;

use TrenchDevs\TrenchDevsClient\Endpoints;

trait ProductsTrait
{

    public function products()
    {
        return $this->get(Endpoints::PRODUCTS_GET); // add filters here
    }

    public function productOne(int $id)
    {
        return $this->get(Endpoints::PRODUCTS_GET_ONE, $id);
    }
}