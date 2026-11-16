<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use DateTime;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\Date;

class CurrentPeriod extends JsonSerializableType
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
     * @var int $requestedDays
     */
    #[JsonProperty('requestedDays')]
    public int $requestedDays;

    /**
     * @var bool $daysCapped
     */
    #[JsonProperty('daysCapped')]
    public bool $daysCapped;

    /**
     * @var int $maxDays
     */
    #[JsonProperty('maxDays')]
    public int $maxDays;

    /**
     * @param array{
     *   startDate: DateTime,
     *   endDate: DateTime,
     *   days: int,
     *   requestedDays: int,
     *   daysCapped: bool,
     *   maxDays: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->startDate = $values['startDate'];
        $this->endDate = $values['endDate'];
        $this->days = $values['days'];
        $this->requestedDays = $values['requestedDays'];
        $this->daysCapped = $values['daysCapped'];
        $this->maxDays = $values['maxDays'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
