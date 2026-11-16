<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Products\Types\SalesHistoryProductsRequestInterval;
use MarktMentor\Products\Types\SalesHistoryProductsRequestMarket;
use MarktMentor\Products\Types\SalesHistoryProductsRequestPeriod;

class SalesHistoryProductsRequest extends JsonSerializableType
{
    /**
     * Bucket size. With period=2Y, use month.
     *
     * * `week` - week
     * * `month` - month
     *
     * @var ?value-of<SalesHistoryProductsRequestInterval> $interval
     */
    public ?string $interval;

    /**
     * @var ?value-of<SalesHistoryProductsRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * * `3M` - 3M
     * * `6M` - 6M
     * * `1Y` - 1Y
     * * `2Y` - 2Y
     *
     * @var ?value-of<SalesHistoryProductsRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   interval?: ?value-of<SalesHistoryProductsRequestInterval>,
     *   market?: ?value-of<SalesHistoryProductsRequestMarket>,
     *   period?: ?value-of<SalesHistoryProductsRequestPeriod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->interval = $values['interval'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->period = $values['period'] ?? null;
    }
}
