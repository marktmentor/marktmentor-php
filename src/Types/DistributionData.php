<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class DistributionData extends JsonSerializableType
{
    /**
     * @var int $productCount Preferred products (no duplicate variants) in the product snapshot of the requested period that match the niche's EANs, including variant EANs. Not restricted to products with sales. It can be much lower than the productCount of Get a niche (example niche 6797: 25,956 in the niche data and 2,934 here).
     */
    #[JsonProperty('productCount')]
    public int $productCount;

    /**
     * @var ?ProductDistributions $total Distributions over the total of both markets (NL and BE together). Price is the price of the period, else the current price. Null when there are no EANs.
     */
    #[JsonProperty('total')]
    public ?ProductDistributions $total;

    /**
     * @param array{
     *   productCount: int,
     *   total?: ?ProductDistributions,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->productCount = $values['productCount'];
        $this->total = $values['total'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
