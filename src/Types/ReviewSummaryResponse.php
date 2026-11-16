<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class ReviewSummaryResponse extends JsonSerializableType
{
    /**
     * @var string $market
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var ReviewSummary $data
     */
    #[JsonProperty('data')]
    public ReviewSummary $data;

    /**
     * @param array{
     *   market: string,
     *   data: ReviewSummary,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
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
