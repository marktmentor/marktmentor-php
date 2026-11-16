<?php

namespace MarktMentor\Reference\Requests;

use MarktMentor\Core\Json\JsonSerializableType;

class BrandsReferenceRequest extends JsonSerializableType
{
    /**
     * @var ?int $limit Maximum number of brands (maximum 100).
     */
    public ?int $limit;

    /**
     * @var string $search Text in the brand name, at least 2 characters. Upper and lower case are the same.
     */
    public string $search;

    /**
     * @param array{
     *   search: string,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->search = $values['search'];
    }
}
