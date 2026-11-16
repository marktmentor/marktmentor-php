<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class SellerSummaryMarkets extends JsonSerializableType
{
    /**
     * @var ?SellerSummaryMetrics $nl
     */
    #[JsonProperty('NL')]
    public ?SellerSummaryMetrics $nl;

    /**
     * @var ?SellerSummaryMetrics $be
     */
    #[JsonProperty('BE')]
    public ?SellerSummaryMetrics $be;

    /**
     * @param array{
     *   nl?: ?SellerSummaryMetrics,
     *   be?: ?SellerSummaryMetrics,
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
