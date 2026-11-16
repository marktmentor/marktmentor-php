<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class Category extends JsonSerializableType
{
    /**
     * @var int $categoryId The bol category identifier. Use it as `categoryId` in the product, niche and store filters.
     */
    #[JsonProperty('categoryId')]
    public int $categoryId;

    /**
     * @var string $name
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var int $level Depth in the tree. Level 1 is the top of the tree.
     */
    #[JsonProperty('level')]
    public int $level;

    /**
     * @var ?int $parentId The category directly above. Null for a level 1 category.
     */
    #[JsonProperty('parentId')]
    public ?int $parentId;

    /**
     * @var array<CategoryPathItem> $path From the level 1 category down to this category, itself included.
     */
    #[JsonProperty('path'), ArrayType([CategoryPathItem::class])]
    public array $path;

    /**
     * @var int $childCount Number of categories directly below. 0: this is a leaf.
     */
    #[JsonProperty('childCount')]
    public int $childCount;

    /**
     * @param array{
     *   categoryId: int,
     *   name: string,
     *   level: int,
     *   path: array<CategoryPathItem>,
     *   childCount: int,
     *   parentId?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->categoryId = $values['categoryId'];
        $this->name = $values['name'];
        $this->level = $values['level'];
        $this->parentId = $values['parentId'] ?? null;
        $this->path = $values['path'];
        $this->childCount = $values['childCount'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
