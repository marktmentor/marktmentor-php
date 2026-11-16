<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class ReviewListResponse extends JsonSerializableType
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
     * @var Pagination $pagination
     */
    #[JsonProperty('pagination')]
    public Pagination $pagination;

    /**
     * @var array<ReviewItem> $data
     */
    #[JsonProperty('data'), ArrayType([ReviewItem::class])]
    public array $data;

    /**
     * @param array{
     *   market: string,
     *   period: string,
     *   pagination: Pagination,
     *   data: array<ReviewItem>,
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
