<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class BrandListResponse extends JsonSerializableType
{
    /**
     * @var bool $hasMore True when more brands match than `limit`. Make the search longer.
     */
    #[JsonProperty('hasMore')]
    public bool $hasMore;

    /**
     * @var array<Brand> $data
     */
    #[JsonProperty('data'), ArrayType([Brand::class])]
    public array $data;

    /**
     * @param array{
     *   hasMore: bool,
     *   data: array<Brand>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->hasMore = $values['hasMore'];
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
