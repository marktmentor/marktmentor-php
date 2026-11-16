<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class StoreChange extends JsonSerializableType
{
    /**
     * @var ?float $revenue
     */
    #[JsonProperty('revenue')]
    public ?float $revenue;

    /**
     * @var ?float $netRevenue
     */
    #[JsonProperty('netRevenue')]
    public ?float $netRevenue;

    /**
     * @var ?float $costs
     */
    #[JsonProperty('costs')]
    public ?float $costs;

    /**
     * @var ?float $profit
     */
    #[JsonProperty('profit')]
    public ?float $profit;

    /**
     * @var ?float $orders
     */
    #[JsonProperty('orders')]
    public ?float $orders;

    /**
     * @var ?float $sales
     */
    #[JsonProperty('sales')]
    public ?float $sales;

    /**
     * @var ?float $returns
     */
    #[JsonProperty('returns')]
    public ?float $returns;

    /**
     * @param array{
     *   revenue?: ?float,
     *   netRevenue?: ?float,
     *   costs?: ?float,
     *   profit?: ?float,
     *   orders?: ?float,
     *   sales?: ?float,
     *   returns?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->revenue = $values['revenue'] ?? null;
        $this->netRevenue = $values['netRevenue'] ?? null;
        $this->costs = $values['costs'] ?? null;
        $this->profit = $values['profit'] ?? null;
        $this->orders = $values['orders'] ?? null;
        $this->sales = $values['sales'] ?? null;
        $this->returns = $values['returns'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
