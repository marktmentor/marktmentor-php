<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class CategoryItem extends JsonSerializableType
{
    /**
     * @var int $categoryId
     */
    #[JsonProperty('categoryId')]
    public int $categoryId;

    /**
     * @var ?string $name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @param array{
     *   categoryId: int,
     *   name?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->categoryId = $values['categoryId'];
        $this->name = $values['name'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
