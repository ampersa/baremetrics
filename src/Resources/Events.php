<?php

namespace Ampersa\Baremetrics\Resources;

use Ampersa\Baremetrics\Support\Response;

class Events extends Resource
{
    /**
     * List the events associated with the provided source
     *
     * @param  string  $sourceId
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list(string $sourceId) : Response
    {
        $endpoint = sprintf('/%s/events', $sourceId);

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of the specific event id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/events/%s', $sourceId, $oid);

        return $this->call('GET', $endpoint);
    }
}
