<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class ProductMarkets extends JsonSerializableType
{
    /**
     * @var ?ProductMarketMetrics $nl
     */
    #[JsonProperty('NL')]
    public ?ProductMarketMetrics $nl;

    /**
     * @var ?ProductMarketMetrics $be
     */
    #[JsonProperty('BE')]
    public ?ProductMarketMetrics $be;

    /**
     * @param array{
     *   nl?: ?ProductMarketMetrics,
     *   be?: ?ProductMarketMetrics,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->nl = $values['nl'] ?? null;
        $this->be = $values['be'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
