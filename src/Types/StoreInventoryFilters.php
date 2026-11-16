<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class StoreInventoryFilters extends JsonSerializableType
{
    /**
     * @var ?string $ean
     */
    #[JsonProperty('ean')]
    public ?string $ean;

    /**
     * @var ?string $stockState
     */
    #[JsonProperty('stockState')]
    public ?string $stockState;

    /**
     * @param array{
     *   ean?: ?string,
     *   stockState?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ean = $values['ean'] ?? null;
        $this->stockState = $values['stockState'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
