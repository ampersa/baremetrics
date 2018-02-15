<?php

namespace Ampersa\Baremetrics\Resources;

use Ampersa\Baremetrics\Support\Response;

class Charges extends Resource
{
    /**
     * List the charges associated with the provided source
     *
     * @param  string  $sourceId
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list(string $sourceId) : Response
    {
        $endpoint = sprintf('/%s/charges', $sourceId);

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of the specific charge id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/charges/%s', $sourceId, $oid);

        return $this->call('GET', $endpoint);
    }

    /**
     * Create a new charge using $data
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function create(string $sourceId, array $data) : Response
    {
        $endpoint = sprintf('/%s/charges', $sourceId);

        return $this->call('POST', $endpoint, $data);
    }

    /**
     * Delete a specific charge by id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function delete(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/charges/%s', $sourceId, $oid);

        return $this->call('DELETE', $endpoint);
    }
}
