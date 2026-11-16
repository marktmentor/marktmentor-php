<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;
use DateTime;
use MarktMentor\Core\Types\Date;

class StoreProductsResponse extends JsonSerializableType
{
    /**
     * @var Period $period
     */
    #[JsonProperty('period')]
    public Period $period;

    /**
     * @var StoreProductsFilters $filters
     */
    #[JsonProperty('filters')]
    public StoreProductsFilters $filters;

    /**
     * @var array<StorePerformanceProductPerformanceItem> $data Products with orders in the period, not the full catalog and not a ranking of the most profitable products.
     */
    #[JsonProperty('data'), ArrayType([StorePerformanceProductPerformanceItem::class])]
    public array $data;

    /**
     * @var StoreProductsPagination $pagination
     */
    #[JsonProperty('pagination')]
    public StoreProductsPagination $pagination;

    /**
     * @var bool $costsVisible False when product and shipping costs are hidden for this store. The profit is then before those costs.
     */
    #[JsonProperty('costsVisible')]
    public bool $costsVisible;

    /**
     * @var DateTime $asOf
     */
    #[JsonProperty('asOf'), Date(Date::TYPE_DATETIME)]
    public DateTime $asOf;

    /**
     * @param array{
     *   period: Period,
     *   filters: StoreProductsFilters,
     *   data: array<StorePerformanceProductPerformanceItem>,
     *   pagination: StoreProductsPagination,
     *   costsVisible: bool,
     *   asOf: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->period = $values['period'];
        $this->filters = $values['filters'];
        $this->data = $values['data'];
        $this->pagination = $values['pagination'];
        $this->costsVisible = $values['costsVisible'];
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
