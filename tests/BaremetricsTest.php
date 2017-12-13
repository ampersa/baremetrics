<?php

namespace Ampersa\Baremetrics\Tests;

use Mockery;
use PHPUnit_Framework_TestCase;

class BaremetricsTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     *
     * @return void
     */
    public function testCallCreatedResourceInstance()
    {
        $clientMock = Mockery::mock(\GuzzleHttp\Client::class);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);

        $this->assertInstanceOf(\Ampersa\Baremetrics\Resources\Account::class, $bm->account());
    }

    /**
     *
     *
     * @return [type]
     */
    public function testExceptionThrownWhenNoClientProvided()
    {
        $this->expectException(\TypeError::class);

        $bm = new \Ampersa\Baremetrics\Baremetrics();
    }

    /**
     *
     *
     * @return [type]
     */
    public function testKeyCanSetAndGet()
    {
        $clientMock = Mockery::mock(\GuzzleHttp\Client::class);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);

        $bm->setKey('12345');

        $this->assertEquals('12345', $bm->getKey());
    }

    /**
     *
     *
     * @return [type]
     */
    public function testExceptionThrownOnInvalidMethod()
    {
        $this->expectException(\Ampersa\Baremetrics\Exceptions\BaremetricsInvalidMethodException::class);

        $clientMock = Mockery::mock(\GuzzleHttp\Client::class);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);

        $result = $bm->doesnotexist();
    }

    /**
     *
     *
     * @return void
     */
    public function testGetThrowsExceptionOnUnauthorizedCall()
    {
        $this->expectException(\Ampersa\Baremetrics\Exceptions\BaremetricsUnauthorizedException::class);

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(401);

        $clientMock = Mockery::mock(\GuzzleHttp\Client::class);
        $clientMock->shouldReceive('request')
                    ->once()
                    ->withArgs(['GET', 'https://api.baremetrics.com/v1/account', ['json' => [], 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->account()->get();
    }

    /**
     *
     *
     * @return void
     */
    public function testExceptionThrownOnBadValidation()
    {
        $this->expectException(\Ampersa\Baremetrics\Exceptions\BaremetricsValidationException::class);
        $this->expectExceptionMessage('The request failed validation');

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(400);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn('{"error":"The request failed validation"}');

        $clientMock = Mockery::mock(\GuzzleHttp\Client::class);
        $clientMock->shouldReceive('request')
                    ->once()
                    ->withArgs(['GET', 'https://api.baremetrics.com/v1/account', ['json' => [], 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->account()->get();
    }
}
