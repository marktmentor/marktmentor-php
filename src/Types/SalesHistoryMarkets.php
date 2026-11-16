<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class SalesHistoryMarkets extends JsonSerializableType
{
    /**
     * @var ?SalesHistoryMetrics $nl
     */
    #[JsonProperty('NL')]
    public ?SalesHistoryMetrics $nl;

    /**
     * @var ?SalesHistoryMetrics $be
     */
    #[JsonProperty('BE')]
    public ?SalesHistoryMetrics $be;

    /**
     * @param array{
     *   nl?: ?SalesHistoryMetrics,
     *   be?: ?SalesHistoryMetrics,
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
