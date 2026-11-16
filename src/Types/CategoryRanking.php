<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class CategoryRanking extends JsonSerializableType
{
    /**
     * @var int $categoryId
     */
    #[JsonProperty('categoryId')]
    public int $categoryId;

    /**
     * @var array<RankPoint> $history
     */
    #[JsonProperty('history'), ArrayType([RankPoint::class])]
    public array $history;

    /**
     * @param array{
     *   categoryId: int,
     *   history: array<RankPoint>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->categoryId = $values['categoryId'];
        $this->history = $values['history'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
