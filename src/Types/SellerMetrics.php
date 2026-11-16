<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class SellerMetrics extends JsonSerializableType
{
    /**
     * @var ?float $buyBoxShare Share of the measured buy-box time in this market. Percentage: 87.4 is 87.4%. Null when no buy-box time was measured.
     */
    #[JsonProperty('buyBoxShare')]
    public ?float $buyBoxShare;

    /**
     * @var ?float $averagePrice
     */
    #[JsonProperty('averagePrice')]
    public ?float $averagePrice;

    /**
     * @var ?float $deliveryDays Most frequent recorded delivery time in days for this market.
     */
    #[JsonProperty('deliveryDays')]
    public ?float $deliveryDays;

    /**
     * @param array{
     *   buyBoxShare?: ?float,
     *   averagePrice?: ?float,
     *   deliveryDays?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->buyBoxShare = $values['buyBoxShare'] ?? null;
        $this->averagePrice = $values['averagePrice'] ?? null;
        $this->deliveryDays = $values['deliveryDays'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
