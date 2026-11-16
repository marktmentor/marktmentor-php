<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class SellerResponse extends JsonSerializableType
{
    /**
     * @var string $market
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var string $period
     */
    #[JsonProperty('period')]
    public string $period;

    /**
     * @var bool $hasMore
     */
    #[JsonProperty('hasMore')]
    public bool $hasMore;

    /**
     * @var SellerSummaryMarkets $markets
     */
    #[JsonProperty('markets')]
    public SellerSummaryMarkets $markets;

    /**
     * @var ListingChanges $listingChanges
     */
    #[JsonProperty('listingChanges')]
    public ListingChanges $listingChanges;

    /**
     * @var array<SellerItem> $data
     */
    #[JsonProperty('data'), ArrayType([SellerItem::class])]
    public array $data;

    /**
     * @param array{
     *   market: string,
     *   period: string,
     *   hasMore: bool,
     *   markets: SellerSummaryMarkets,
     *   listingChanges: ListingChanges,
     *   data: array<SellerItem>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->period = $values['period'];
        $this->hasMore = $values['hasMore'];
        $this->markets = $values['markets'];
        $this->listingChanges = $values['listingChanges'];
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
