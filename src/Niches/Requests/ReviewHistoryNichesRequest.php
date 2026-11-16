<?php

namespace MarktMentor\Niches\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Niches\Types\ReviewHistoryNichesRequestInterval;
use MarktMentor\Niches\Types\ReviewHistoryNichesRequestMarket;
use MarktMentor\Niches\Types\ReviewHistoryNichesRequestPeriod;

class ReviewHistoryNichesRequest extends JsonSerializableType
{
    /**
     * Bucket size. With period=2Y, use month.
     *
     * * `week` - week
     * * `month` - month
     *
     * @var ?value-of<ReviewHistoryNichesRequestInterval> $interval
     */
    public ?string $interval;

    /**
     * @var ?value-of<ReviewHistoryNichesRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * * `3M` - 3M
     * * `6M` - 6M
     * * `1Y` - 1Y
     * * `2Y` - 2Y
     *
     * @var ?value-of<ReviewHistoryNichesRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   interval?: ?value-of<ReviewHistoryNichesRequestInterval>,
     *   market?: ?value-of<ReviewHistoryNichesRequestMarket>,
     *   period?: ?value-of<ReviewHistoryNichesRequestPeriod>,
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
