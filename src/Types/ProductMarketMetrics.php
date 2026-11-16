<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class ProductMarketMetrics extends JsonSerializableType
{
    /**
     * @var ?float $price
     */
    #[JsonProperty('price')]
    public ?float $price;

    /**
     * @var ?float $sales
     */
    #[JsonProperty('sales')]
    public ?float $sales;

    /**
     * @var ?float $revenue
     */
    #[JsonProperty('revenue')]
    public ?float $revenue;

    /**
     * @var ?float $impressions
     */
    #[JsonProperty('impressions')]
    public ?float $impressions;

    /**
     * @var ?int $sellerCount
     */
    #[JsonProperty('sellerCount')]
    public ?int $sellerCount;

    /**
     * @var ?float $searchTermCount Search terms the product ranked for in the period.
     */
    #[JsonProperty('searchTermCount')]
    public ?float $searchTermCount;

    /**
     * @var ?float $deliveryDays Average promised delivery time in days.
     */
    #[JsonProperty('deliveryDays')]
    public ?float $deliveryDays;

    /**
     * @param array{
     *   price?: ?float,
     *   sales?: ?float,
     *   revenue?: ?float,
     *   impressions?: ?float,
     *   sellerCount?: ?int,
     *   searchTermCount?: ?float,
     *   deliveryDays?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->price = $values['price'] ?? null;
        $this->sales = $values['sales'] ?? null;
        $this->revenue = $values['revenue'] ?? null;
        $this->impressions = $values['impressions'] ?? null;
        $this->sellerCount = $values['sellerCount'] ?? null;
        $this->searchTermCount = $values['searchTermCount'] ?? null;
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
