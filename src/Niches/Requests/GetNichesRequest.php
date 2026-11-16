<?php

namespace MarktMentor\Niches\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Niches\Types\GetNichesRequestMarket;
use MarktMentor\Niches\Types\GetNichesRequestPeriod;

class GetNichesRequest extends JsonSerializableType
{
    /**
     * @var ?bool $comparePeriods Include core niche metrics for 30d, 90d and 365d in data.periods.
     */
    public ?bool $comparePeriods;

    /**
     * @var ?value-of<GetNichesRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * * `30d` - 30d
     * * `90d` - 90d
     * * `365d` - 365d
     *
     * @var ?value-of<GetNichesRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   comparePeriods?: ?bool,
     *   market?: ?value-of<GetNichesRequestMarket>,
     *   period?: ?value-of<GetNichesRequestPeriod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->comparePeriods = $values['comparePeriods'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->period = $values['period'] ?? null;
    }
}
