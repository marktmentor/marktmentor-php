<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class Dimensions extends JsonSerializableType
{
    /**
     * @var ?float $lengthCm
     */
    #[JsonProperty('lengthCm')]
    public ?float $lengthCm;

    /**
     * @var ?float $widthCm
     */
    #[JsonProperty('widthCm')]
    public ?float $widthCm;

    /**
     * @var ?float $heightCm
     */
    #[JsonProperty('heightCm')]
    public ?float $heightCm;

    /**
     * @var ?float $weightGrams
     */
    #[JsonProperty('weightGrams')]
    public ?float $weightGrams;

    /**
     * @var ?string $packageType bol shipping package type, such as Pakket M.
     */
    #[JsonProperty('packageType')]
    public ?string $packageType;

    /**
     * @param array{
     *   lengthCm?: ?float,
     *   widthCm?: ?float,
     *   heightCm?: ?float,
     *   weightGrams?: ?float,
     *   packageType?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->lengthCm = $values['lengthCm'] ?? null;
        $this->widthCm = $values['widthCm'] ?? null;
        $this->heightCm = $values['heightCm'] ?? null;
        $this->weightGrams = $values['weightGrams'] ?? null;
        $this->packageType = $values['packageType'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
