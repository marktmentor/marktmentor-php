<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class NicheMetrics extends JsonSerializableType
{
    /**
     * @var ?float $searchVolume
     */
    #[JsonProperty('searchVolume')]
    public ?float $searchVolume;

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
     * @param array{
     *   searchVolume?: ?float,
     *   sales?: ?float,
     *   revenue?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->searchVolume = $values['searchVolume'] ?? null;
        $this->sales = $values['sales'] ?? null;
        $this->revenue = $values['revenue'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
