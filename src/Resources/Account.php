<?php

namespace Ampersa\Baremetrics\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Support\Response;

class Account extends Resource
{
    /**
     * Get the current authenticated account details
     *
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function get() : Response
    {
        return $this->call('GET', '/account');
    }
}
