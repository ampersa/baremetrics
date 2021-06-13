<?php

namespace Ampersa\Baremetrics\Tests;

use Mockery;

class AnnotationsTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     *
     * @return void
     */
    public function testListCallsCorrectEndpointAndReturnsExpected()
    {
        $responseJson = '{"annotations": [{"id": "our_unique_id", "metric": "mrr", "annotation": "New Feature 1", "date": "2015-03-31", "global": true, "user": {"id": "user_id", "email": "user@baremetrics.com", "admin": true, "name": "User Name"} } ] }';

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
                    ->withArgs(['GET', 'https://api.baremetrics.com/v1/annotations', ['json' => [], 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->annotations()->list();

        $this->assertEquals('New Feature 1', $result->annotations[0]->annotation);
    }

    /**
     *
     *
     * @return void
     */
    public function testCreateCallsCorrectEndpointAndReturnsExpected()
    {
        $requestData = [
            'metric' => 'mrr',
            'annotation' => 'New Feature 1',
            'date' => '2017-01-01',
            'global' => true,
            'user_id' => 1,
        ];

        $responseJson = '{"annotations": [{"id": "our_unique_id", "metric": "mrr", "annotation": "New Feature 1", "date": "2015-03-31", "global": true, "user": {"id": "user_id", "email": "user@baremetrics.com", "admin": true, "name": "User Name"} } ] }';

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
                    ->withArgs(['POST', 'https://api.baremetrics.com/v1/annotations', ['json' => $requestData, 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->annotations()->create($requestData);

        $this->assertEquals('New Feature 1', $result->annotations[0]->annotation);
    }
}
