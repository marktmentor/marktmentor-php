<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Products\Types\SellersProductsRequestMarket;
use MarktMentor\Products\Types\SellersProductsRequestPeriod;

class SellersProductsRequest extends JsonSerializableType
{
    /**
     * @var ?value-of<SellersProductsRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * * `90d` - 90d
     * * `180d` - 180d
     * * `365d` - 365d
     * * `730d` - 730d
     *
     * @var ?value-of<SellersProductsRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   market?: ?value-of<SellersProductsRequestMarket>,
     *   period?: ?value-of<SellersProductsRequestPeriod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->period = $values['period'] ?? null;
    }
}
