<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class CategoryListResponse extends JsonSerializableType
{
    /**
     * @var Pagination $pagination
     */
    #[JsonProperty('pagination')]
    public Pagination $pagination;

    /**
     * @var array<Category> $data
     */
    #[JsonProperty('data'), ArrayType([Category::class])]
    public array $data;

    /**
     * @param array{
     *   pagination: Pagination,
     *   data: array<Category>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
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
