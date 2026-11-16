<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class NicheMarkets extends JsonSerializableType
{
    /**
     * @var ?NicheMetrics $nl
     */
    #[JsonProperty('NL')]
    public ?NicheMetrics $nl;

    /**
     * @var ?NicheMetrics $be
     */
    #[JsonProperty('BE')]
    public ?NicheMetrics $be;

    /**
     * @param array{
     *   nl?: ?NicheMetrics,
     *   be?: ?NicheMetrics,
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
