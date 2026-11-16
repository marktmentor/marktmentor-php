<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class StoreProductsFilters extends JsonSerializableType
{
    /**
     * @var ?string $country
     */
    #[JsonProperty('country')]
    public ?string $country;

    /**
     * @var ?array<string> $eans
     */
    #[JsonProperty('eans'), ArrayType(['string'])]
    public ?array $eans;

    /**
     * @var ?int $categoryId
     */
    #[JsonProperty('categoryId')]
    public ?int $categoryId;

    /**
     * @param array{
     *   country?: ?string,
     *   eans?: ?array<string>,
     *   categoryId?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->country = $values['country'] ?? null;
        $this->eans = $values['eans'] ?? null;
        $this->categoryId = $values['categoryId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
