<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class StoreInventoryCounts extends JsonSerializableType
{
    /**
     * @var int $resolved
     */
    #[JsonProperty('resolved')]
    public int $resolved;

    /**
     * @var int $outOfStock
     */
    #[JsonProperty('outOfStock')]
    public int $outOfStock;

    /**
     * @var int $low
     */
    #[JsonProperty('low')]
    public int $low;

    /**
     * @var int $ok
     */
    #[JsonProperty('ok')]
    public int $ok;

    /**
     * @var int $unknown
     */
    #[JsonProperty('unknown')]
    public int $unknown;

    /**
     * @param array{
     *   resolved: int,
     *   outOfStock: int,
     *   low: int,
     *   ok: int,
     *   unknown: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->resolved = $values['resolved'];
        $this->outOfStock = $values['outOfStock'];
        $this->low = $values['low'];
        $this->ok = $values['ok'];
        $this->unknown = $values['unknown'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
