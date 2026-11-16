<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Products\Types\CategoryRankingsProductsRequestInterval;
use MarktMentor\Products\Types\CategoryRankingsProductsRequestMarket;
use MarktMentor\Products\Types\CategoryRankingsProductsRequestPeriod;

class CategoryRankingsProductsRequest extends JsonSerializableType
{
    /**
     * Bucket size. With period=2Y, use month.
     *
     * * `week` - week
     * * `month` - month
     *
     * @var ?value-of<CategoryRankingsProductsRequestInterval> $interval
     */
    public ?string $interval;

    /**
     * @var ?value-of<CategoryRankingsProductsRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * * `3M` - 3M
     * * `6M` - 6M
     * * `1Y` - 1Y
     * * `2Y` - 2Y
     *
     * @var ?value-of<CategoryRankingsProductsRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   interval?: ?value-of<CategoryRankingsProductsRequestInterval>,
     *   market?: ?value-of<CategoryRankingsProductsRequestMarket>,
     *   period?: ?value-of<CategoryRankingsProductsRequestPeriod>,
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
