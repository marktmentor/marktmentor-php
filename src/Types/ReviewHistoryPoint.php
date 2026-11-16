<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use DateTime;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\Date;

class ReviewHistoryPoint extends JsonSerializableType
{
    /**
     * @var DateTime $date
     */
    #[JsonProperty('date'), Date(Date::TYPE_DATE)]
    public DateTime $date;

    /**
     * @var int $reviewCount
     */
    #[JsonProperty('reviewCount')]
    public int $reviewCount;

    /**
     * @var ?float $averageRating Average rating, in stars from 1 to 5.
     */
    #[JsonProperty('averageRating')]
    public ?float $averageRating;

    /**
     * @param array{
     *   date: DateTime,
     *   reviewCount: int,
     *   averageRating?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->date = $values['date'];
        $this->reviewCount = $values['reviewCount'];
        $this->averageRating = $values['averageRating'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
