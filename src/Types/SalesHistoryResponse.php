<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class SalesHistoryResponse extends JsonSerializableType
{
    /**
     * @var string $market
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var string $period
     */
    #[JsonProperty('period')]
    public string $period;

    /**
     * @var string $interval
     */
    #[JsonProperty('interval')]
    public string $interval;

    /**
     * @var array<SalesHistoryPoint> $data
     */
    #[JsonProperty('data'), ArrayType([SalesHistoryPoint::class])]
    public array $data;

    /**
     * @param array{
     *   market: string,
     *   period: string,
     *   interval: string,
     *   data: array<SalesHistoryPoint>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->period = $values['period'];
        $this->interval = $values['interval'];
        $this->data = $values['data'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
