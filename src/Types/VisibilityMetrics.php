<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class VisibilityMetrics extends JsonSerializableType
{
    /**
     * @var ?float $categoryImpressions
     */
    #[JsonProperty('categoryImpressions')]
    public ?float $categoryImpressions;

    /**
     * @var ?float $keywordImpressions
     */
    #[JsonProperty('keywordImpressions')]
    public ?float $keywordImpressions;

    /**
     * @param array{
     *   categoryImpressions?: ?float,
     *   keywordImpressions?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->categoryImpressions = $values['categoryImpressions'] ?? null;
        $this->keywordImpressions = $values['keywordImpressions'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
