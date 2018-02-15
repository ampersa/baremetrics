<?php

namespace Ampersa\Baremetrics\Resources;

use DateTime;
use Ampersa\Baremetrics\Support\Response;

class Metrics extends Resource
{
    /**
     * Get the metrics summary
     *
     * @param  DateTime $start
     * @param  DateTime $end
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function summary(DateTime $start, DateTime $end) : Response
    {
        $endpoint = sprintf(
            '/metrics?start_date=%s&end_date=%s',
            $start->format('Y-m-d'),
            $end->format('Y-m-d')
        );

        return $this->call('GET', $endpoint);
    }

    /**
     * Retrieve a specific metric
     *
     * @param  string   $metric
     * @param  DateTime $start
     * @param  DateTime $end
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function metric(string $metric, DateTime $start, DateTime $end) : Response
    {
        $endpoint = sprintf(
            '/metrics/%s?start_date=%s&end_date=%s',
            $metric,
            $start->format('Y-m-d'),
            $end->format('Y-m-d')
        );

        return $this->call('GET', $endpoint);
    }

    /**
     * Retrieve a specific metric between $start and $end with customer data
     *
     * @param  string   $metric
     * @param  DateTime $start
     * @param  DateTime $end
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function customers(string $metric, DateTime $start, DateTime $end) : Response
    {
        $endpoint = sprintf(
            '/metrics/%s/customers?start_date=%s&end_date=%s',
            $metric,
            $start->format('Y-m-d'),
            $end->format('Y-m-d')
        );

        return $this->call('GET', $endpoint);
    }

    /**
     * Retrieve a specific metric between $start and $end with plan data
     *
     * @param  string   $metric
     * @param  DateTime $start
     * @param  DateTime $end
     * @return Ampersa\Baremetrics\Support\Response
     */
    public function plans(string $metric, DateTime $start, DateTime $end) : Response
    {
        $endpoint = sprintf(
            '/metrics/%s/plans?start_date=%s&end_date=%s',
            $metric,
            $start->format('Y-m-d'),
            $end->format('Y-m-d')
        );

        return $this->call('GET', $endpoint);
    }
}
