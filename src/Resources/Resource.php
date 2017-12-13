<?php

namespace Ampersa\Baremetrics\Resources;

use Ampersa\Baremetrics\Baremetrics;
use Ampersa\Baremetrics\Support\Response;
use Ampersa\Baremetrics\Exceptions\BaremetricsValidationException;
use Ampersa\Baremetrics\Exceptions\BaremetricsUnauthorizedException;

class Resource
{
    /** @var Ampersa\Baremetrics\Baremetrics */
    protected $parent;

    public function __construct(Baremetrics $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Perform a request against the API and return the decoded response
     *
     * @param  string $method
     * @param  string $endpoint
     * @param  array  $data
     * @return object
     */
    protected function call(string $method, string $endpoint, array $data = [])
    {
        $uri = $this->prepareUri($endpoint);

        $headers = $this->buildHeadersWithAuthorization();

        $response = $this->parent->client()->request(
            $method,
            $uri,
            [
                'json' => $data,
                'headers' => $headers,
            ]
        );

        if ($response->getStatusCode() == 401) {
            throw new BaremetricsUnauthorizedException;
        }

        if ($response->getStatusCode() == 400) {
            $errorBody = (string) $response->getBody();
            $errorMessage = json_decode($errorBody);

            throw new BaremetricsValidationException($errorMessage->error);
        }

        return new Response($response);
    }

    /**
     * Build an array of headers for the request, including the Authorization header
     *
     * @param  array $headers
     * @return array
     */
    protected function buildHeadersWithAuthorization(array $headers = []) : array
    {
        $headers['Authorization'] = sprintf('Bearer %s', $this->parent->getKey());

        return $headers;
    }

    /**
     * Prepare the given endpoint string into a fully qualified URL
     *
     * @param  string $endpoint
     * @return string
     */
    protected function prepareUri(string $endpoint) : string
    {
        return sprintf(
            '%s/%s',
            rtrim($this->parent->baseUrl, '/'),
            ltrim($endpoint, '/')
        );
    }
}
