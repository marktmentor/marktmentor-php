<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class ReviewSummary extends JsonSerializableType
{
    /**
     * @var ?float $averageRating Average rating, in stars from 1 to 5.
     */
    #[JsonProperty('averageRating')]
    public ?float $averageRating;

    /**
     * @var int $reviewCount Reviews that MarktMentor holds for this selection. This can be lower than reviewCount of the product object, which is the number bol shows.
     */
    #[JsonProperty('reviewCount')]
    public int $reviewCount;

    /**
     * @var array<RatingCount> $ratings
     */
    #[JsonProperty('ratings'), ArrayType([RatingCount::class])]
    public array $ratings;

    /**
     * @var array<ReviewTopic> $positiveTopics
     */
    #[JsonProperty('positiveTopics'), ArrayType([ReviewTopic::class])]
    public array $positiveTopics;

    /**
     * @var array<ReviewTopic> $negativeTopics
     */
    #[JsonProperty('negativeTopics'), ArrayType([ReviewTopic::class])]
    public array $negativeTopics;

    /**
     * @param array{
     *   reviewCount: int,
     *   ratings: array<RatingCount>,
     *   positiveTopics: array<ReviewTopic>,
     *   negativeTopics: array<ReviewTopic>,
     *   averageRating?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->averageRating = $values['averageRating'] ?? null;
        $this->reviewCount = $values['reviewCount'];
        $this->ratings = $values['ratings'];
        $this->positiveTopics = $values['positiveTopics'];
        $this->negativeTopics = $values['negativeTopics'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
