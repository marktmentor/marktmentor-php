<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class SalesHistoryMetrics extends JsonSerializableType
{
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
     * @var ?float $price
     */
    #[JsonProperty('price')]
    public ?float $price;

    /**
     * @param array{
     *   sales?: ?float,
     *   revenue?: ?float,
     *   price?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->sales = $values['sales'] ?? null;
        $this->revenue = $values['revenue'] ?? null;
        $this->price = $values['price'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
