<?php

namespace Ampersa\Baremetrics\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Support\Response;

class Sources extends Resource
{
    /**
     * List the accounts sources
     *
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list() : Response
    {
        return $this->call('GET', '/sources');
    }
}
