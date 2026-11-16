<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class CategoryResponse extends JsonSerializableType
{
    /**
     * @var Category $data
     */
    #[JsonProperty('data')]
    public Category $data;

    /**
     * @param array{
     *   data: Category,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
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
