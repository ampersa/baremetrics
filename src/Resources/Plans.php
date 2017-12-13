<?php

namespace Ampersa\Baremetrics\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Support\Response;

class Plans extends Resource
{
    /**
     * List the plans associated with the provided source
     *
     * @param  string  $sourceId
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list(string $sourceId) : Response
    {
        $endpoint = sprintf('/%s/plans', $sourceId);

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of the specific plan id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/plans/%s', $sourceId, $oid);

        return $this->call('GET', $endpoint);
    }

    /**
     * Update the specified plan with $data
     *
     * @param  string $sourceId
     * @param  string $oid
     * @param  array  $data
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function update(string $sourceId, string $oid, array $data) : Response
    {
        $endpoint = sprintf('/%s/plans/%s', $sourceId, $oid);

        return $this->call('PUT', $endpoint, $data);
    }

    /**
     * Show the details of the specific plan id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function create(string $sourceId, array $data) : Response
    {
        $endpoint = sprintf('/%s/plans', $sourceId);

        return $this->call('POST', $endpoint, $data);
    }

    /**
     * Delete a specific plan by id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function delete(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/plans/%s', $sourceId, $oid);

        return $this->call('DELETE', $endpoint);
    }
}
