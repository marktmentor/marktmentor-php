<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class RankMarkets extends JsonSerializableType
{
    /**
     * @var ?float $nl
     */
    #[JsonProperty('NL')]
    public ?float $nl;

    /**
     * @var ?float $be
     */
    #[JsonProperty('BE')]
    public ?float $be;

    /**
     * @param array{
     *   nl?: ?float,
     *   be?: ?float,
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
