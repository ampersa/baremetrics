<?php

namespace Ampersa\Baremetrics\Tests;

use Mockery;

class AccountTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     *
     * @return void
     */
    public function testGetCallsCorrectEndpointAndReturnsExpected()
    {
        $responseJson = '{"plan": {"oid": "basic_plan", "source_id": "123", "source": "baremetrics", "name": "Basic", "interval": "month", "interval_count": 1, "trial_duration": null, "trial_duration_unit": null, "created": null, "active": true, "setup_fees": 0, "amounts": [{"currency": "USD", "symbol": "$", "symbol_right": false, "amount": 1000 } ] } }';

        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $responseMock->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn(200);
        $responseMock->shouldReceive('getHeaders')
                    ->once()
                    ->andReturn([]);
        $responseMock->shouldReceive('getBody')
                    ->once()
                    ->andReturn($responseJson);

        $clientMock = Mockery::mock(\GuzzleHttp\Client::class);
        $clientMock->shouldReceive('request')
                    ->once()
                    ->withArgs(['GET', 'https://api.baremetrics.com/v1/account', ['json' => [], 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->account()->get();

        $this->assertEquals('basic_plan', $result->plan->oid);
    }
}
