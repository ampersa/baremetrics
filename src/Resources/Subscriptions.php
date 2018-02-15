<?php

namespace Ampersa\Baremetrics\Resources;

use Ampersa\Baremetrics\Support\Response;

class Subscriptions extends Resource
{
    /**
     * List the subscriptions associated with the provided source
     *
     * @param  string  $sourceId
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list(string $sourceId) : Response
    {
        $endpoint = sprintf('/%s/subscriptions', $sourceId);

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of the specific subscription id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/subscriptions/%s', $sourceId, $oid);

        return $this->call('GET', $endpoint);
    }

    /**
     * Update the specified subscription with $data
     *
     * @param  string $sourceId
     * @param  string $oid
     * @param  array  $data
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function update(string $sourceId, string $oid, array $data) : Response
    {
        $endpoint = sprintf('/%s/subscriptions/%s', $sourceId, $oid);

        return $this->call('PUT', $endpoint, $data);
    }

    /**
     * Cancel the specified subscription with $data
     *
     * @param  string $sourceId
     * @param  string $oid
     * @param  array  $data
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function cancel(string $sourceId, string $oid, array $data) : Response
    {
        $endpoint = sprintf('/%s/subscriptions/%s/cancel', $sourceId, $oid);

        return $this->call('PUT', $endpoint, $data);
    }

    /**
     * Create a new subscription using $data
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function create(string $sourceId, array $data) : Response
    {
        $endpoint = sprintf('/%s/subscriptions', $sourceId);

        return $this->call('POST', $endpoint, $data);
    }

    /**
     * Delete a specific subscription by id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function delete(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/subscriptions/%s', $sourceId, $oid);

        return $this->call('DELETE', $endpoint);
    }
}
