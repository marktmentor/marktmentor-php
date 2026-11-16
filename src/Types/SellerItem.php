<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class SellerItem extends JsonSerializableType
{
    /**
     * @var string $sellerCode
     */
    #[JsonProperty('sellerCode')]
    public string $sellerCode;

    /**
     * @var ?string $name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?float $rating Seller rating on bol, on a scale up to 10. Not in stars.
     */
    #[JsonProperty('rating')]
    public ?float $rating;

    /**
     * @var SellerMarkets $markets
     */
    #[JsonProperty('markets')]
    public SellerMarkets $markets;

    /**
     * @param array{
     *   sellerCode: string,
     *   markets: SellerMarkets,
     *   name?: ?string,
     *   rating?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->sellerCode = $values['sellerCode'];
        $this->name = $values['name'] ?? null;
        $this->rating = $values['rating'] ?? null;
        $this->markets = $values['markets'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
