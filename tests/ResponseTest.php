<?php

namespace Ampersa\Baremetrics\Tests;

use Mockery;
use PHPUnit_Framework_TestCase;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     *
     * @return void
     */
    public function testResponseCanBeConstructedWithManualArguments()
    {
        $object = json_decode('{"values":[4,5,6],"test":{"test1":"test2"}}');

        $response = new \Ampersa\Baremetrics\Support\Response($object, ['Origin' => 'Baremetrics'], 200);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     *
     *
     * @return void
     */
    public function testResponseCanBeConstructedWithPsrResponse()
    {
        $responseJson = '{"values":[4,5,6],"test":{"test1":"test2"}}';

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(200);
        $responseMock->shouldReceive('getHeaders')
                    ->once()
                    ->andReturn(['Origin' => 'Baremetrics']);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn($responseJson);

        $response = new \Ampersa\Baremetrics\Support\Response($responseMock);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     *
     *
     * @return void
     */
    public function testRateLimitsAreExtractedFromResponse()
    {
        $responseJson = '{"values":[4,5,6],"test":{"test1":"test2"}}';

        $headers = ['X-RateLimit-Remaining' => 99, 'X-RateLimit-Limit' => 100];

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(200);
        $responseMock->shouldReceive('getHeaders')
                    ->once()
                    ->andReturn($headers);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn($responseJson);

        $response = new \Ampersa\Baremetrics\Support\Response($responseMock);

        $this->assertEquals(['limit' => 100, 'remain' => 99], $response->getRateLimits());
    }

    /**
     *
     *
     * @return void
     */
    public function testDefaultRateLimitsAreReturnedWhenNoHeaderPresent()
    {
        $responseJson = '{"values":[4,5,6],"test":{"test1":"test2"}}';

        $headers = [];

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(200);
        $responseMock->shouldReceive('getHeaders')
                    ->once()
                    ->andReturn($headers);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn($responseJson);

        $response = new \Ampersa\Baremetrics\Support\Response($responseMock);

        $this->assertEquals(['limit' => 0, 'remain' => 0], $response->getRateLimits());
    }

    /**
     *
     *
     * @return void
     */
    public function testDataCanBeExtractedFromJsonResponse()
    {
        $responseJson = '{"values":[4,5,6],"test":{"test1":"test2"}}';

        $headers = ['X-RateLimit-Remaining' => 99, 'X-RateLimit-Limit' => 100];

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(200);
        $responseMock->shouldReceive('getHeaders')
                    ->once()
                    ->andReturn($headers);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn($responseJson);

        $response = new \Ampersa\Baremetrics\Support\Response($responseMock);

        $this->assertEquals('test2', $response->test->test1);
    }

    /**
     *
     *
     * @return void
     */
    public function testHeadersCanBeReturnedFromResponse()
    {
        $responseJson = '{"values":[4,5,6],"test":{"test1":"test2"}}';

        $headers = ['X-RateLimit-Remaining' => 99, 'X-RateLimit-Limit' => 100];

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(200);
        $responseMock->shouldReceive('getHeaders')
                    ->once()
                    ->andReturn($headers);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn($responseJson);

        $response = new \Ampersa\Baremetrics\Support\Response($responseMock);

        $this->assertEquals($headers, $response->getHeaders());
    }

    /**
     *
     *
     * @return void
     */
    public function testNonExistentDataReturnsAsFalse()
    {
        $responseJson = '{"values":[4,5,6],"test":{"test1":"test2"}}';

        $headers = ['X-RateLimit-Remaining' => 99, 'X-RateLimit-Limit' => 100];

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(200);
        $responseMock->shouldReceive('getHeaders')
                    ->once()
                    ->andReturn($headers);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn($responseJson);

        $response = new \Ampersa\Baremetrics\Support\Response($responseMock);

        $this->assertFalse($response->notexist);
    }

    /**
     *
     *
     * @return void
     */
    public function testDataIssetReturnsCorrectly()
    {
        $responseJson = '{"values":[4,5,6],"test":{"test1":"test2"}}';

        $headers = ['X-RateLimit-Remaining' => 99, 'X-RateLimit-Limit' => 100];

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(200);
        $responseMock->shouldReceive('getHeaders')
                    ->once()
                    ->andReturn($headers);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn($responseJson);

        $response = new \Ampersa\Baremetrics\Support\Response($responseMock);

        $this->assertTrue(isset($response->values));
        $this->assertFalse(isset($response->notexist));
    }
}
