<?php

namespace Ampersa\Baremetrics\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Support\Response;

class Annotations extends Resource
{
    /**
     * List the annotations from the account
     *
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list() : Response
    {
        $endpoint = sprintf('/annotations');

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of a specific annotation
     *
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $oid) : Response
    {
        $endpoint = sprintf('/annotations/%s', $oid);

        return $this->call('GET', $endpoint);
    }

    /**
     * Create a new annotation
     *
     * @param  array $data
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function create(array $data) : Response
    {
        $endpoint = sprintf('/annotations');

        return $this->call('POST', $endpoint, $data);
    }

    /**
     * Delete an annotation by id
     *
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function delete(string $oid) : Response
    {
        $endpoint = sprintf('/annotations/%s', $oid);

        return $this->call('DELETE', $endpoint);
    }
}
