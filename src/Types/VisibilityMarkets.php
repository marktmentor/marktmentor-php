<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class VisibilityMarkets extends JsonSerializableType
{
    /**
     * @var ?VisibilityMetrics $nl
     */
    #[JsonProperty('NL')]
    public ?VisibilityMetrics $nl;

    /**
     * @var ?VisibilityMetrics $be
     */
    #[JsonProperty('BE')]
    public ?VisibilityMetrics $be;

    /**
     * @param array{
     *   nl?: ?VisibilityMetrics,
     *   be?: ?VisibilityMetrics,
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
