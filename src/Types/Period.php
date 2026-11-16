<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use DateTime;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\Date;

class Period extends JsonSerializableType
{
    /**
     * @var DateTime $startDate
     */
    #[JsonProperty('startDate'), Date(Date::TYPE_DATE)]
    public DateTime $startDate;

    /**
     * @var DateTime $endDate
     */
    #[JsonProperty('endDate'), Date(Date::TYPE_DATE)]
    public DateTime $endDate;

    /**
     * @var int $days
     */
    #[JsonProperty('days')]
    public int $days;

    /**
     * @param array{
     *   startDate: DateTime,
     *   endDate: DateTime,
     *   days: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->startDate = $values['startDate'];
        $this->endDate = $values['endDate'];
        $this->days = $values['days'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
