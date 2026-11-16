<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class ListingChanges extends JsonSerializableType
{
    /**
     * @var ?int $mainImage
     */
    #[JsonProperty('mainImage')]
    public ?int $mainImage;

    /**
     * @var ?int $title
     */
    #[JsonProperty('title')]
    public ?int $title;

    /**
     * @var ?int $description
     */
    #[JsonProperty('description')]
    public ?int $description;

    /**
     * @param array{
     *   mainImage?: ?int,
     *   title?: ?int,
     *   description?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->mainImage = $values['mainImage'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->description = $values['description'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
