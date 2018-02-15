<?php

namespace Ampersa\Baremetrics\Tests;

use Mockery;
use TypeError;
use PHPUnit_Framework_TestCase;

class MetricsTest extends PHPUnit_Framework_TestCase
{
    public function testSummaryCallsCorrectEndpointAndReturnsExpected()
    {
        $responseJson = '{"metrics": [{"human_date": "2016-11-26", "date": 1480118400, "active_customers": 642, "active_subscriptions": 642, "add_on_mrr": 0, "arpu": 9383, "arr": 72289044, "cancellations": 0, "coupons": 43300, "downgrades": 0, "failed_charges": 1, "fees": 7373, "ltv": 159039, "mrr": 6024087, "net_revenue": 233498, "new_customers": 0, "other_revenue": 0, "reactivated_customers": 0, "refunds": 0, "revenue_churn": 543, "trial_conversions": 0, "upgrades": 1, "user_churn": 590 }, {"human_date": "2016-11-27", "date": 1480204800, "active_customers": 640, "active_subscriptions": 640, "add_on_mrr": 0, "arpu": 9362, "arr": 71900916, "cancellations": 2, "coupons": 6677, "downgrades": 1, "failed_charges": 1, "fees": 4452, "ltv": 158949, "mrr": 5991743, "net_revenue": 129723, "new_customers": 0, "other_revenue": 0, "reactivated_customers": 0, "refunds": 0, "revenue_churn": 497, "trial_conversions": 0, "upgrades": 1, "user_churn": 589 } ] }';

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
                    ->withArgs(['GET', 'https://api.baremetrics.com/v1/metrics?start_date=2016-11-01&end_date=2016-11-26', ['json' => [], 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->metrics()->summary(new \DateTime('01 November 2016'), new \DateTime('26 November 2016'));

        $this->assertEquals(2, count($result->metrics));
        $this->assertEquals(233498, $result->metrics[0]->net_revenue);
    }

    public function testExceptionThrownWhenNonDateTimeGivenToSummary()
    {
        $this->expectException(TypeError::class);

        $clientMock = Mockery::mock(\GuzzleHttp\Client::class);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->metrics()->summary('01 November 2016', '26 November 2016');
    }

    public function testMetricCallsCorrectEndpointAndReturnsExpected()
    {
        $responseJson = '{"metrics": [{"date": 1480118400, "human_date": "2016-11-26", "value": 6024087, "notes": null, "previous": {"date": 1477526400, "human_date": "2016-10-27", "value": 5941979, "percent": 1.4, "notes": null } }, {"date": 1480204800, "human_date": "2016-11-27", "value": 5991743, "notes": null, "previous": {"date": 1477612800, "human_date": "2016-10-28", "value": 5932562, "percent": 1, "notes": null } }, {"date": 1480291200, "human_date": "2016-11-28", "value": 6050735, "notes": null, "previous": {"date": 1477699200, "human_date": "2016-10-29", "value": 5940529, "percent": 1.9, "notes": null } }, {"date": 1480377600, "human_date": "2016-11-29", "value": 6076135, "notes": null, "previous": {"date": 1477785600, "human_date": "2016-10-30", "value": 5935279, "percent": 2.4, "notes": null } } ] }';

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
                    ->withArgs(['GET', 'https://api.baremetrics.com/v1/metrics/upgrades?start_date=2016-11-01&end_date=2016-11-26', ['json' => [], 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->metrics()->metric('upgrades', new \DateTime('01 November 2016'), new \DateTime('26 November 2016'));

        $this->assertEquals(4, count($result->metrics));
        $this->assertEquals(5932562, $result->metrics[1]->previous->value);
    }

    public function testCustomersCallsCorrectEndpointAndReturnsExpected()
    {
        $responseJson = '{"metrics": [{"date": 1475107200, "human_date": "2016-09-29", "value": 2, "customers": [{"mrr": 5000, "customer": {"oid": "customer_1", "source_id": "source_1", "source": "stripe", "created": 1492605754, "email": "customer_1@baremetrics.com", "name": "Customer 1", "display_image": "https://logo.clearbit.com/baremetrics.com", "display_name": "Customer 1", "notes": "Here are some notes", "ltv": 50000 }, "current_plan": {"oid": "mrr_50_mo", "source_id": "stripe_1", "source": "stripe", "name": "Startup $50 - MRR - Monthly", "interval": "month", "interval_count": 1, "trial_duration": null, "trial_duration_unit": null, "created": 1450216295, "active": true, "setup_fees": 0, "amounts": [{"currency": "USD", "symbol": "$", "symbol_right": false, "amount": 5000 } ] }, "previous_plan": {"oid": "free", "source_id": "stripe_1", "source": "stripe", "name": "Free", "interval": "month", "interval_count": 1, "trial_duration": 14, "trial_duration_unit": "day", "created": 1438620623, "active": true, "setup_fees": 0, "amounts": [{"currency": "USD", "symbol": "$", "symbol_right": false, "amount": 0 } ] } } ] } ] }';

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
                    ->withArgs(['GET', 'https://api.baremetrics.com/v1/metrics/upgrades/customers?start_date=2016-11-01&end_date=2016-11-26', ['json' => [], 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->metrics()->customers('upgrades', new \DateTime('01 November 2016'), new \DateTime('26 November 2016'));

        $this->assertEquals(1, count($result->metrics));
        $this->assertEquals(2, $result->metrics[0]->value);
        $this->assertEquals('https://logo.clearbit.com/baremetrics.com', $result->metrics[0]->customers[0]->customer->display_image);
    }

    public function testPlansCallsCorrectEndpointAndReturnsExpected()
    {
        $responseJson = '{"metrics": [{"date": 1477872000, "human_date": "2016-10-31", "value": 52664, "plan": {"oid": "startup_yearly_790", "source_id": "3ULWIj59pU016O", "source": "stripe", "name": "Startup (Yearly)", "interval": "year", "interval_count": 1, "trial_duration": null, "trial_duration_unit": null, "created": 1394818080, "active": true, "setup_fees": 0, "amounts": [{"currency": "USD", "symbol": "$", "symbol_right": false, "amount": 79000 } ] } } ] }';

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
                    ->withArgs(['GET', 'https://api.baremetrics.com/v1/metrics/upgrades/plans?start_date=2016-11-01&end_date=2016-11-26', ['json' => [], 'headers' => ['Authorization' => 'Bearer 12345']]])
                    ->andReturn($responseMock);

        $bm = new \Ampersa\Baremetrics\Baremetrics($clientMock);
        $bm->setKey('12345');
        $result = $bm->metrics()->plans('upgrades', new \DateTime('01 November 2016'), new \DateTime('26 November 2016'));

        $this->assertEquals(1, count($result->metrics));
        $this->assertEquals(52664, $result->metrics[0]->value);
        $this->assertEquals('3ULWIj59pU016O', $result->metrics[0]->plan->source_id);
    }
}
