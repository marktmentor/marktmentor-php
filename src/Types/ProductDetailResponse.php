<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class ProductDetailResponse extends JsonSerializableType
{
    /**
     * * `NL` - NL
     * * `BE` - BE
     * * `ALL` - ALL
     *
     * @var value-of<ProductDetailResponseMarket> $market
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var string $period
     */
    #[JsonProperty('period')]
    public string $period;

    /**
     * @var ProductDetail $data
     */
    #[JsonProperty('data')]
    public ProductDetail $data;

    /**
     * @param array{
     *   market: value-of<ProductDetailResponseMarket>,
     *   period: string,
     *   data: ProductDetail,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
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
