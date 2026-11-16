<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Products\Types\KeywordRankingsProductsRequestInterval;
use MarktMentor\Products\Types\KeywordRankingsProductsRequestMarket;
use MarktMentor\Products\Types\KeywordRankingsProductsRequestPeriod;

class KeywordRankingsProductsRequest extends JsonSerializableType
{
    /**
     * Bucket size. With period=2Y, use month.
     *
     * * `week` - week
     * * `month` - month
     *
     * @var ?value-of<KeywordRankingsProductsRequestInterval> $interval
     */
    public ?string $interval;

    /**
     * @var ?string $keywordIds Up to 25 keywordId values from the keywords endpoint, separated by commas. Without it, the response has the 10 keywords of the keywords endpoint with the highest search volume in the last 30 days.
     */
    public ?string $keywordIds;

    /**
     * @var ?value-of<KeywordRankingsProductsRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * * `3M` - 3M
     * * `6M` - 6M
     * * `1Y` - 1Y
     * * `2Y` - 2Y
     *
     * @var ?value-of<KeywordRankingsProductsRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   interval?: ?value-of<KeywordRankingsProductsRequestInterval>,
     *   keywordIds?: ?string,
     *   market?: ?value-of<KeywordRankingsProductsRequestMarket>,
     *   period?: ?value-of<KeywordRankingsProductsRequestPeriod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->interval = $values['interval'] ?? null;
        $this->keywordIds = $values['keywordIds'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->period = $values['period'] ?? null;
    }
}
