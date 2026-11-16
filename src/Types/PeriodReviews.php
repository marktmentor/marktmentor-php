<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class PeriodReviews extends JsonSerializableType
{
    /**
     * @var ?int $count Reviews placed during the period.
     */
    #[JsonProperty('count')]
    public ?int $count;

    /**
     * @var ?float $averageRating Average of those reviews, in stars from 1 to 5. Null without reviews.
     */
    #[JsonProperty('averageRating')]
    public ?float $averageRating;

    /**
     * @var PeriodRatings $ratings Reviews in the period per star rating.
     */
    #[JsonProperty('ratings')]
    public PeriodRatings $ratings;

    /**
     * @param array{
     *   ratings: PeriodRatings,
     *   count?: ?int,
     *   averageRating?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->count = $values['count'] ?? null;
        $this->averageRating = $values['averageRating'] ?? null;
        $this->ratings = $values['ratings'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
