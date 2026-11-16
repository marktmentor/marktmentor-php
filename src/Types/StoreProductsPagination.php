<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class StoreProductsPagination extends JsonSerializableType
{
    /**
     * @var int $page
     */
    #[JsonProperty('page')]
    public int $page;

    /**
     * @var int $pageSize
     */
    #[JsonProperty('pageSize')]
    public int $pageSize;

    /**
     * @var ?int $total Number of selected products with orders in the period. This is not the size of the catalog. null: the page is empty and it is not the first page, thus the total is unknown.
     */
    #[JsonProperty('total')]
    public ?int $total;

    /**
     * @var bool $hasNext
     */
    #[JsonProperty('hasNext')]
    public bool $hasNext;

    /**
     * @var bool $totalMayBeCapped True when the total is unknown or is 1,000 or more. The source selects at most 1,000 EANs: the selection can then be incomplete. Use the EAN or category filter to make it smaller.
     */
    #[JsonProperty('totalMayBeCapped')]
    public bool $totalMayBeCapped;

    /**
     * @param array{
     *   page: int,
     *   pageSize: int,
     *   hasNext: bool,
     *   totalMayBeCapped: bool,
     *   total?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->page = $values['page'];
        $this->pageSize = $values['pageSize'];
        $this->total = $values['total'] ?? null;
        $this->hasNext = $values['hasNext'];
        $this->totalMayBeCapped = $values['totalMayBeCapped'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
