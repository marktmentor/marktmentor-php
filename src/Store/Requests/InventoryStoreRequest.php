<?php

namespace MarktMentor\Store\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Store\Types\InventoryStoreRequestStockState;

class InventoryStoreRequest extends JsonSerializableType
{
    /**
     * @var ?string $ean Only the product with this EAN.
     */
    public ?string $ean;

    /**
     * @var ?int $page Page number, starting at 1.
     */
    public ?int $page;

    /**
     * @var ?int $pageSize Results per page (maximum 100).
     */
    public ?int $pageSize;

    /**
     * out_of_stock: the stock is zero. low: the stock is 5 or less. ok: more than 5.
     *
     * * `out_of_stock` - out_of_stock
     * * `low` - low
     * * `ok` - ok
     *
     * @var ?value-of<InventoryStoreRequestStockState> $stockState
     */
    public ?string $stockState;

    /**
     * @param array{
     *   ean?: ?string,
     *   page?: ?int,
     *   pageSize?: ?int,
     *   stockState?: ?value-of<InventoryStoreRequestStockState>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ean = $values['ean'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->pageSize = $values['pageSize'] ?? null;
        $this->stockState = $values['stockState'] ?? null;
    }
}
