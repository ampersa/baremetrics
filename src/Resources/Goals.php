<?php

namespace Ampersa\Baremetrics\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Support\Response;

class Goals extends Resource
{
    /**
     * List the goals from the account
     *
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list() : Response
    {
        $endpoint = sprintf('/goals');

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of a specific goal
     *
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $oid) : Response
    {
        $endpoint = sprintf('/goals/%s', $oid);

        return $this->call('GET', $endpoint);
    }

    /**
     * Create a new goal
     *
     * @param  array $data
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function create(array $data) : Response
    {
        $endpoint = sprintf('/goals');

        return $this->call('POST', $endpoint, $data);
    }

    /**
     * Delete an goal by id
     *
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function delete(string $oid) : Response
    {
        $endpoint = sprintf('/goals/%s', $oid);

        return $this->call('DELETE', $endpoint);
    }
}
