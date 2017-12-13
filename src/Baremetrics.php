<?php

namespace Ampersa\Baremetrics;

use InvalidArgumentException;
use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Exceptions\BaremetricsInvalidMethodException;

class Baremetrics
{
    /** @var GuzzleHttp\Client  A HTTP client instance for HTTP communication */
    protected $client;

    /** @var string  An authentication key for the Baremetrics API */
    protected $key;

    /** @var string  The base URL for the Baremetrics API */
    public $baseUrl = 'https://api.baremetrics.com/v1';

    /** @var array  A map of available resources to their respective classes */
    protected $resources = [
        'account' => \Ampersa\Baremetrics\Resources\Account::class,
        'sources' => Resources\Sources::class,
        'plans' => Resources\Plans::class,
        'customers' => Resources\Customers::class,
        'subscriptions' => Resources\Subscriptions::class,
        'annotations' => Resources\Annotations::class,
        'users' => Resources\Users::class,
        'goals' => Resources\Goals::class,
        'charges' => Resources\Charges::class,
        'refunds' => Resources\Refunds::class,
        'events' => Resources\Events::class,
        'metrics' => Resources\Metrics::class,
        'segments' => Resources\Segments::class,
    ];

    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * Set the authentication key for the
     *
     * @param string $key
     */
    public function setKey(string $key) : self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Retrieve the currently set authentication key
     *
     * @param string $key
     */
    public function getKey() : string
    {
        return $this->key;
    }

    /**
     * Return the Client instance
     *
     * @return GuzzleHttp\Client
     */
    public function client() : GuzzleClient
    {
        return $this->client;
    }

    /**
     * Handles calls to resources via the arrow method
     *
     * @param  string $method
     * @param  array  $attrs
     * @return Ampersa\Baremetrics\Resources\Resource
     */
    public function __call(string $method, array $attrs)
    {
        if (! array_key_exists($method, $this->resources)) {
            throw new BaremetricsInvalidMethodException('The resource [' . $method . '] does not exist');
        }

        $resource = $this->resources[$method];

        $instance = new $resource($this);

        return $instance;
    }
}
