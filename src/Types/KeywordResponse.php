<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class KeywordResponse extends JsonSerializableType
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
     * @var array<KeywordItem> $data
     */
    #[JsonProperty('data'), ArrayType([KeywordItem::class])]
    public array $data;

    /**
     * @param array{
     *   market: string,
     *   period: string,
     *   pagination: Pagination,
     *   data: array<KeywordItem>,
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
