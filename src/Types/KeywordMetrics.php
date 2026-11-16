<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class KeywordMetrics extends JsonSerializableType
{
    /**
     * @var ?float $searchVolume
     */
    #[JsonProperty('searchVolume')]
    public ?float $searchVolume;

    /**
     * @var ?float $position
     */
    #[JsonProperty('position')]
    public ?float $position;

    /**
     * @param array{
     *   searchVolume?: ?float,
     *   position?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->searchVolume = $values['searchVolume'] ?? null;
        $this->position = $values['position'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
