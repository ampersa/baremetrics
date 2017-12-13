<?php

namespace Ampersa\Baremetrics\Support;

use GuzzleHttp\Psr7\Response as PsrResponse;

class Response
{
    /** @var object  The data returned within the response */
    protected $data;

    /** @var int  The status code returned by the API */
    protected $statusCode;

    /** @var array  An array of headers returned from the API */
    protected $headers;

    public function __construct($data, array $headers = [], int $statusCode = 0)
    {
        // Test the first argument for an instance of GuzzleHttp\Psr7\Response. If
        // this matches as true, then we can extract the elements we require from
        // the instance. Otherwise, set the data manually from the set arguments
        if ($data instanceof PsrResponse) {
            $this->data = json_decode((string) $data->getBody());
            $this->headers = $data->getHeaders();
            $this->statusCode = $data->getStatusCode();

            return;
        }

        $this->data = $data;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    /**
     * Return the response status code
     *
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    /**
     * Return the response headers
     *
     * @return int
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * Return the rate limit values from the response headers
     *
     * @return int
     */
    public function getRateLimits() : array
    {
        if (isset($this->headers['X-RateLimit-Remaining']) and isset($this->headers['X-RateLimit-Limit'])) {
            return [
                'limit' => $this->headers['X-RateLimit-Limit'],
                'remain' => $this->headers['X-RateLimit-Remaining'],
            ];
        }

        return [
            'limit' => 0,
            'remain' => 0,
        ];
    }

    /**
     * Get data from the responde
     *
     * @param  string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        if (isset($this->data->{$key})) {
            return $this->data->{$key};
        }

        return false;
    }

    /**
     * Check existence of a key on $data
     *
     * @param  string $key
     * @return mixed
     */
    public function __isset(string $key)
    {
        return isset($this->data->{$key});
    }
}
