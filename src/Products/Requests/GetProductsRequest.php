<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Products\Types\GetProductsRequestMarket;
use MarktMentor\Products\Types\GetProductsRequestPeriod;

class GetProductsRequest extends JsonSerializableType
{
    /**
     * @var ?value-of<GetProductsRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * * `30d` - 30d
     * * `90d` - 90d
     * * `365d` - 365d
     *
     * @var ?value-of<GetProductsRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   market?: ?value-of<GetProductsRequestMarket>,
     *   period?: ?value-of<GetProductsRequestPeriod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->period = $values['period'] ?? null;
    }
}
