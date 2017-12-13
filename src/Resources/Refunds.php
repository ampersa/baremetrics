<?php

namespace Ampersa\Baremetrics\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Support\Response;

class Refunds extends Resource
{
    /**
     * List the refunds associated with the provided source
     *
     * @param  string  $sourceId
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function list(string $sourceId) : Response
    {
        $endpoint = sprintf('/%s/refunds', $sourceId);

        return $this->call('GET', $endpoint);
    }

    /**
     * Show the details of the specific refund id
     *
     * @param  string $sourceId
     * @param  string $oid
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function show(string $sourceId, string $oid) : Response
    {
        $endpoint = sprintf('/%s/refunds/%s', $sourceId, $oid);

        return $this->call('GET', $endpoint);
    }
}
