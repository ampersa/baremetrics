<?php

namespace Ampersa\Baremetrics\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Support\Response;

class Users extends Resource
{
    /**
     * List the users from the account
     *
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list() : Response
    {
        $endpoint = sprintf('/users');

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of a specific user
     *
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $oid) : Response
    {
        $endpoint = sprintf('/users/%s', $oid);

        return $this->call('GET', $endpoint);
    }
}
