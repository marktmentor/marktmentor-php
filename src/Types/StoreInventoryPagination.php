<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class StoreInventoryPagination extends JsonSerializableType
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
     * @var int $total Active products that match the filters.
     */
    #[JsonProperty('total')]
    public int $total;

    /**
     * @var bool $hasNext
     */
    #[JsonProperty('hasNext')]
    public bool $hasNext;

    /**
     * @param array{
     *   page: int,
     *   pageSize: int,
     *   total: int,
     *   hasNext: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->page = $values['page'];
        $this->pageSize = $values['pageSize'];
        $this->total = $values['total'];
        $this->hasNext = $values['hasNext'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
