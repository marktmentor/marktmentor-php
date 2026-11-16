<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use DateTime;
use MarktMentor\Core\Types\Date;

class StoreInventoryRow extends JsonSerializableType
{
    /**
     * @var string $ean
     */
    #[JsonProperty('ean')]
    public string $ean;

    /**
     * @var string $title
     */
    #[JsonProperty('title')]
    public string $title;

    /**
     * @var ?int $stock Stock of the active fulfilment method of the product: the regular stock at bol (LvB / FBB) or the corrected own stock (VvB / FBR). null when the stock is unknown.
     */
    #[JsonProperty('stock')]
    public ?int $stock;

    /**
     * unknown is not zero: see unknownReason.
     *
     * * `out_of_stock` - out_of_stock
     * * `low` - low
     * * `ok` - ok
     * * `unknown` - unknown
     *
     * @var value-of<StoreInventoryRowStockState> $stockState
     */
    #[JsonProperty('stockState')]
    public string $stockState;

    /**
     * @var ?string $source
     */
    #[JsonProperty('source')]
    public ?string $source;

    /**
     * @var ?DateTime $stockLastUpdated
     */
    #[JsonProperty('stockLastUpdated'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $stockLastUpdated;

    /**
     * @var ?string $unknownReason
     */
    #[JsonProperty('unknownReason')]
    public ?string $unknownReason;

    /**
     * @param array{
     *   ean: string,
     *   title: string,
     *   stockState: value-of<StoreInventoryRowStockState>,
     *   stock?: ?int,
     *   source?: ?string,
     *   stockLastUpdated?: ?DateTime,
     *   unknownReason?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ean = $values['ean'];
        $this->title = $values['title'];
        $this->stock = $values['stock'] ?? null;
        $this->stockState = $values['stockState'];
        $this->source = $values['source'] ?? null;
        $this->stockLastUpdated = $values['stockLastUpdated'] ?? null;
        $this->unknownReason = $values['unknownReason'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
