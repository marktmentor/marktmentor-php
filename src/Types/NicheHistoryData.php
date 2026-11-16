<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class NicheHistoryData extends JsonSerializableType
{
    /**
     * @var array<ReviewHistoryPoint> $reviews
     */
    #[JsonProperty('reviews'), ArrayType([ReviewHistoryPoint::class])]
    public array $reviews;

    /**
     * @param array{
     *   reviews: array<ReviewHistoryPoint>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->reviews = $values['reviews'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
