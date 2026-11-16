<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use DateTime;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\Date;

class VisibilityPoint extends JsonSerializableType
{
    /**
     * @var DateTime $date
     */
    #[JsonProperty('date'), Date(Date::TYPE_DATE)]
    public DateTime $date;

    /**
     * @var VisibilityMarkets $markets
     */
    #[JsonProperty('markets')]
    public VisibilityMarkets $markets;

    /**
     * @param array{
     *   date: DateTime,
     *   markets: VisibilityMarkets,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->date = $values['date'];
        $this->markets = $values['markets'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
