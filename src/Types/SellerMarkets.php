<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class SellerMarkets extends JsonSerializableType
{
    /**
     * @var ?SellerMetrics $nl
     */
    #[JsonProperty('NL')]
    public ?SellerMetrics $nl;

    /**
     * @var ?SellerMetrics $be
     */
    #[JsonProperty('BE')]
    public ?SellerMetrics $be;

    /**
     * @param array{
     *   nl?: ?SellerMetrics,
     *   be?: ?SellerMetrics,
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
