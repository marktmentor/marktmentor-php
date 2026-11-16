<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class NicheDistributionsResponse extends JsonSerializableType
{
    /**
     * @var string $period
     */
    #[JsonProperty('period')]
    public string $period;

    /**
     * @var DistributionData $data
     */
    #[JsonProperty('data')]
    public DistributionData $data;

    /**
     * @param array{
     *   period: string,
     *   data: DistributionData,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->period = $values['period'];
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
