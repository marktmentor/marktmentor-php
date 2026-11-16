<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class ProductDistributions extends JsonSerializableType
{
    /**
     * @var array<DistributionBucket> $price
     */
    #[JsonProperty('price'), ArrayType([DistributionBucket::class])]
    public array $price;

    /**
     * @var array<DistributionBucket> $sales
     */
    #[JsonProperty('sales'), ArrayType([DistributionBucket::class])]
    public array $sales;

    /**
     * @var array<DistributionBucket> $revenue
     */
    #[JsonProperty('revenue'), ArrayType([DistributionBucket::class])]
    public array $revenue;

    /**
     * @param array{
     *   price: array<DistributionBucket>,
     *   sales: array<DistributionBucket>,
     *   revenue: array<DistributionBucket>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->price = $values['price'];
        $this->sales = $values['sales'];
        $this->revenue = $values['revenue'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
