<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class ProductListResponse extends JsonSerializableType
{
    /**
     * * `NL` - NL
     * * `BE` - BE
     * * `ALL` - ALL
     *
     * @var value-of<ProductListResponseMarket> $market
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var string $period
     */
    #[JsonProperty('period')]
    public string $period;

    /**
     * @var Pagination $pagination
     */
    #[JsonProperty('pagination')]
    public Pagination $pagination;

    /**
     * @var array<ProductItem> $data
     */
    #[JsonProperty('data'), ArrayType([ProductItem::class])]
    public array $data;

    /**
     * @param array{
     *   market: value-of<ProductListResponseMarket>,
     *   period: string,
     *   pagination: Pagination,
     *   data: array<ProductItem>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->period = $values['period'];
        $this->pagination = $values['pagination'];
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
