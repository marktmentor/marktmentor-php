<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;
use DateTime;
use MarktMentor\Core\Types\Date;

class StoreInventoryResponse extends JsonSerializableType
{
    /**
     * @var StoreInventoryFilters $filters
     */
    #[JsonProperty('filters')]
    public StoreInventoryFilters $filters;

    /**
     * @var array<StoreInventoryRow> $data
     */
    #[JsonProperty('data'), ArrayType([StoreInventoryRow::class])]
    public array $data;

    /**
     * @var StoreInventoryPagination $pagination
     */
    #[JsonProperty('pagination')]
    public StoreInventoryPagination $pagination;

    /**
     * @var StoreInventoryCounts $counts
     */
    #[JsonProperty('counts')]
    public StoreInventoryCounts $counts;

    /**
     * resolved_page: the counts are for this page only (no stockState filter). resolved_catalogue: the counts are for all active products (with a stockState filter).
     *
     * * `resolved_page` - resolved_page
     * * `resolved_catalogue` - resolved_catalogue
     *
     * @var value-of<StoreInventoryResponseCountsScope> $countsScope
     */
    #[JsonProperty('countsScope')]
    public string $countsScope;

    /**
     * @var DateTime $asOf
     */
    #[JsonProperty('asOf'), Date(Date::TYPE_DATETIME)]
    public DateTime $asOf;

    /**
     * @param array{
     *   filters: StoreInventoryFilters,
     *   data: array<StoreInventoryRow>,
     *   pagination: StoreInventoryPagination,
     *   counts: StoreInventoryCounts,
     *   countsScope: value-of<StoreInventoryResponseCountsScope>,
     *   asOf: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->filters = $values['filters'];
        $this->data = $values['data'];
        $this->pagination = $values['pagination'];
        $this->counts = $values['counts'];
        $this->countsScope = $values['countsScope'];
        $this->asOf = $values['asOf'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
