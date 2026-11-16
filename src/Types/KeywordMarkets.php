<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class KeywordMarkets extends JsonSerializableType
{
    /**
     * @var ?KeywordMetrics $nl
     */
    #[JsonProperty('NL')]
    public ?KeywordMetrics $nl;

    /**
     * @var ?KeywordMetrics $be
     */
    #[JsonProperty('BE')]
    public ?KeywordMetrics $be;

    /**
     * @param array{
     *   nl?: ?KeywordMetrics,
     *   be?: ?KeywordMetrics,
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
