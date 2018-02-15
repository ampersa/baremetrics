<?php

namespace Ampersa\Baremetrics\Resources;

use Ampersa\Baremetrics\Support\Response;

class Customers extends Resource
{
    /**
     * List the customers associated with the provided source
     *
     * @param  string  $sourceId
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list(string $sourceId) : Response
    {
        $endpoint = sprintf('/%s/customers', $sourceId);

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of the specific customer id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/customers/%s', $sourceId, $oid);

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the events for a specific customer by id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function events(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/customers/%s/events', $sourceId, $oid);

        return $this->call('GET', $endpoint);
    }

    /**
     * Update the specified customer with $data
     *
     * @param  string $sourceId
     * @param  string $oid
     * @param  array  $data
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function update(string $sourceId, string $oid, array $data) : Response
    {
        $endpoint = sprintf('/%s/customers/%s', $sourceId, $oid);

        return $this->call('PUT', $endpoint, $data);
    }

    /**
     * Create a new customer using $data
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function create(string $sourceId, array $data) : Response
    {
        $endpoint = sprintf('/%s/customers', $sourceId);

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
        $endpoint = sprintf('/%s/customers/%s', $sourceId, $oid);

        return $this->call('DELETE', $endpoint);
    }
}
