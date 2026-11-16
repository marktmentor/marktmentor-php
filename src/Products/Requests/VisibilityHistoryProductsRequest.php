<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Products\Types\VisibilityHistoryProductsRequestInterval;
use MarktMentor\Products\Types\VisibilityHistoryProductsRequestMarket;
use MarktMentor\Products\Types\VisibilityHistoryProductsRequestPeriod;

class VisibilityHistoryProductsRequest extends JsonSerializableType
{
    /**
     * Bucket size. With period=2Y, use month.
     *
     * * `week` - week
     * * `month` - month
     *
     * @var ?value-of<VisibilityHistoryProductsRequestInterval> $interval
     */
    public ?string $interval;

    /**
     * @var ?value-of<VisibilityHistoryProductsRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * * `3M` - 3M
     * * `6M` - 6M
     * * `1Y` - 1Y
     * * `2Y` - 2Y
     *
     * @var ?value-of<VisibilityHistoryProductsRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   interval?: ?value-of<VisibilityHistoryProductsRequestInterval>,
     *   market?: ?value-of<VisibilityHistoryProductsRequestMarket>,
     *   period?: ?value-of<VisibilityHistoryProductsRequestPeriod>,
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
