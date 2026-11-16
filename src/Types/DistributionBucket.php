<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class DistributionBucket extends JsonSerializableType
{
    /**
     * @var ?float $fromValue
     */
    #[JsonProperty('fromValue')]
    public ?float $fromValue;

    /**
     * @var ?float $toValue
     */
    #[JsonProperty('toValue')]
    public ?float $toValue;

    /**
     * @var int $productCount
     */
    #[JsonProperty('productCount')]
    public int $productCount;

    /**
     * @param array{
     *   productCount: int,
     *   fromValue?: ?float,
     *   toValue?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->fromValue = $values['fromValue'] ?? null;
        $this->toValue = $values['toValue'] ?? null;
        $this->productCount = $values['productCount'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
