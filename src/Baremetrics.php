<?php

namespace Ampersa\Baremetrics;

use InvalidArgumentException;
use UnexpectedValueException;
use GuzzleHttp\Client as GuzzleClient;
use Ampersa\Baremetrics\Exceptions\BaremetricsInvalidMethodException;

class Baremetrics
{
    /** @var GuzzleHttp\Client  A HTTP client instance for HTTP communication */
    protected $client;

    /** @var string  An authentication key for the Baremetrics API */
    protected $key;

    /** @var array  An array of base URLs for the Baremetrics API */
    protected $baseUrls = [
        'live' => 'https://api.baremetrics.com/v1',
        'sandbox' => 'https://api-sandbox.baremetrics.com/v1',
    ];

    /** @var string  The environment to communicate to the API in (Accepts: live, sandbox) */
    public $environment = 'live';

    /** @var array  A map of available resources to their respective classes */
    protected $resources = [
        'account' => Resources\Account::class,
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
    ];


    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * Set the authentication key for the
     *
     * @param  string $key
     * @return  Baremetrics
     */
    public function setKey(string $key) : self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Retrieve the currently set authentication key
     *
     * @return  string
     */
    public function getKey() : string
    {
        return $this->key;
    }

    /**
     * Get the base URL for communication with the API
     *
     * @return string
     */
    public function getBaseUrl() : string
    {
        if (! isset($this->baseUrls[$this->environment])) {
            throw new UnexpectedValueException('[' . $this->environment .'] is not a valid communication environment');
        }

        return $this->baseUrls[$this->environment];
    }

    /**
     * Set the environment for communication
     *
     * @param   string $env
     * @return  Baremetrics
     */
    public function setEnvironment(string $env) : self
    {
        $this->environment = $env;

        return $this;
    }

    /**
     * Return the current environment
     *
     * @return string
     */
    public function getEnvironment() : string
    {
        return $this->environment;
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
