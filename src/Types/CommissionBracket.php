<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class CommissionBracket extends JsonSerializableType
{
    /**
     * @var ?float $priceBelow Applies to sale prices below this amount. Null for the top bracket.
     */
    #[JsonProperty('priceBelow')]
    public ?float $priceBelow;

    /**
     * @var ?float $fixed Fixed fee in euros.
     */
    #[JsonProperty('fixed')]
    public ?float $fixed;

    /**
     * @var ?float $percentage Percentage of the sale price.
     */
    #[JsonProperty('percentage')]
    public ?float $percentage;

    /**
     * @param array{
     *   priceBelow?: ?float,
     *   fixed?: ?float,
     *   percentage?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->priceBelow = $values['priceBelow'] ?? null;
        $this->fixed = $values['fixed'] ?? null;
        $this->percentage = $values['percentage'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
