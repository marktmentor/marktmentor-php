<?php

namespace MarktMentor\Reference\Requests;

use MarktMentor\Core\Json\JsonSerializableType;

class CategoriesReferenceRequest extends JsonSerializableType
{
    /**
     * @var ?int $level Only categories of this level. Level 1 is the top of the tree.
     */
    public ?int $level;

    /**
     * @var ?int $page Page number, starting at 1.
     */
    public ?int $page;

    /**
     * @var ?int $pageSize Results per page (maximum 200).
     */
    public ?int $pageSize;

    /**
     * @var ?int $parentId Only the categories directly below this category.
     */
    public ?int $parentId;

    /**
     * @var ?string $search Text in the category name. Every word must be in the name. Upper and lower case are the same.
     */
    public ?string $search;

    /**
     * @param array{
     *   level?: ?int,
     *   page?: ?int,
     *   pageSize?: ?int,
     *   parentId?: ?int,
     *   search?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->level = $values['level'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->pageSize = $values['pageSize'] ?? null;
        $this->parentId = $values['parentId'] ?? null;
        $this->search = $values['search'] ?? null;
    }
}
