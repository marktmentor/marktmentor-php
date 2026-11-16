<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use DateTime;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\Date;

class SalesHistoryPoint extends JsonSerializableType
{
    /**
     * @var DateTime $date
     */
    #[JsonProperty('date'), Date(Date::TYPE_DATE)]
    public DateTime $date;

    /**
     * @var SalesHistoryMarkets $markets
     */
    #[JsonProperty('markets')]
    public SalesHistoryMarkets $markets;

    /**
     * @param array{
     *   date: DateTime,
     *   markets: SalesHistoryMarkets,
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
