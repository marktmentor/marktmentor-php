<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class SellerSummaryMetrics extends JsonSerializableType
{
    /**
     * @var int $buyBoxSellerCount Returned sellers with a positive measured buy-box share. May be incomplete when hasMore is true.
     */
    #[JsonProperty('buyBoxSellerCount')]
    public int $buyBoxSellerCount;

    /**
     * @var ?int $buyBoxTakeovers
     */
    #[JsonProperty('buyBoxTakeovers')]
    public ?int $buyBoxTakeovers;

    /**
     * @var ?float $averageHoursInBuyBox
     */
    #[JsonProperty('averageHoursInBuyBox')]
    public ?float $averageHoursInBuyBox;

    /**
     * @param array{
     *   buyBoxSellerCount: int,
     *   buyBoxTakeovers?: ?int,
     *   averageHoursInBuyBox?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->buyBoxSellerCount = $values['buyBoxSellerCount'];
        $this->buyBoxTakeovers = $values['buyBoxTakeovers'] ?? null;
        $this->averageHoursInBuyBox = $values['averageHoursInBuyBox'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
