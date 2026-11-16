<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class RatingCount extends JsonSerializableType
{
    /**
     * @var int $rating Number of stars, from 1 to 5.
     */
    #[JsonProperty('rating')]
    public int $rating;

    /**
     * @var int $count
     */
    #[JsonProperty('count')]
    public int $count;

    /**
     * @param array{
     *   rating: int,
     *   count: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->rating = $values['rating'];
        $this->count = $values['count'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
