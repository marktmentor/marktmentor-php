<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use DateTime;
use MarktMentor\Core\Types\Date;
use MarktMentor\Core\Types\ArrayType;

class ProductDetail extends JsonSerializableType
{
    /**
     * @var string $productCode
     */
    #[JsonProperty('productCode')]
    public string $productCode;

    /**
     * @var ?string $ean
     */
    #[JsonProperty('ean')]
    public ?string $ean;

    /**
     * @var ?string $title
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * @var ?string $brand
     */
    #[JsonProperty('brand')]
    public ?string $brand;

    /**
     * @var ?string $familyName Name of the product family (its variant group).
     */
    #[JsonProperty('familyName')]
    public ?string $familyName;

    /**
     * @var ?string $imageUrl
     */
    #[JsonProperty('imageUrl')]
    public ?string $imageUrl;

    /**
     * @var ?DateTime $availableSince The first day MarktMentor saw the product on bol. For a product that came on bol after MarktMentor started to follow its category, this is about its launch date. An older product can be on bol for longer.
     */
    #[JsonProperty('availableSince'), Date(Date::TYPE_DATE)]
    public ?DateTime $availableSince;

    /**
     * @var ?float $rating Average rating over all reviews, in stars from 1 to 5.
     */
    #[JsonProperty('rating')]
    public ?float $rating;

    /**
     * @var ?int $reviewCount Number of reviews as bol shows it for the product, counted over the product family. The review endpoints can hold fewer reviews.
     */
    #[JsonProperty('reviewCount')]
    public ?int $reviewCount;

    /**
     * @var PeriodReviews $periodReviews
     */
    #[JsonProperty('periodReviews')]
    public PeriodReviews $periodReviews;

    /**
     * @var ?string $updatedAt Date of the data snapshot the figures come from.
     */
    #[JsonProperty('updatedAt')]
    public ?string $updatedAt;

    /**
     * @var array<CategoryItem> $categories
     */
    #[JsonProperty('categories'), ArrayType([CategoryItem::class])]
    public array $categories;

    /**
     * @var ?float $mainCategoryPosition Average position in the main category during the period.
     */
    #[JsonProperty('mainCategoryPosition')]
    public ?float $mainCategoryPosition;

    /**
     * @var Dimensions $dimensions
     */
    #[JsonProperty('dimensions')]
    public Dimensions $dimensions;

    /**
     * @var ?bool $lvbPossible Whether the dimensions fit bol fulfilment (LvB).
     */
    #[JsonProperty('lvbPossible')]
    public ?bool $lvbPossible;

    /**
     * @var ?array<CommissionBracket> $commission bol commission brackets for the product's category, as bol publishes them (including 21% VAT).
     */
    #[JsonProperty('commission'), ArrayType([CommissionBracket::class])]
    public ?array $commission;

    /**
     * @var ProductMarkets $markets
     */
    #[JsonProperty('markets')]
    public ProductMarkets $markets;

    /**
     * @var array<string> $variantCodes Other products in the same family. Search products with variantsOf returns their data in one request.
     */
    #[JsonProperty('variantCodes'), ArrayType(['string'])]
    public array $variantCodes;

    /**
     * @param array{
     *   productCode: string,
     *   periodReviews: PeriodReviews,
     *   categories: array<CategoryItem>,
     *   dimensions: Dimensions,
     *   markets: ProductMarkets,
     *   variantCodes: array<string>,
     *   ean?: ?string,
     *   title?: ?string,
     *   brand?: ?string,
     *   familyName?: ?string,
     *   imageUrl?: ?string,
     *   availableSince?: ?DateTime,
     *   rating?: ?float,
     *   reviewCount?: ?int,
     *   updatedAt?: ?string,
     *   mainCategoryPosition?: ?float,
     *   lvbPossible?: ?bool,
     *   commission?: ?array<CommissionBracket>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->productCode = $values['productCode'];
        $this->ean = $values['ean'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->brand = $values['brand'] ?? null;
        $this->familyName = $values['familyName'] ?? null;
        $this->imageUrl = $values['imageUrl'] ?? null;
        $this->availableSince = $values['availableSince'] ?? null;
        $this->rating = $values['rating'] ?? null;
        $this->reviewCount = $values['reviewCount'] ?? null;
        $this->periodReviews = $values['periodReviews'];
        $this->updatedAt = $values['updatedAt'] ?? null;
        $this->categories = $values['categories'];
        $this->mainCategoryPosition = $values['mainCategoryPosition'] ?? null;
        $this->dimensions = $values['dimensions'];
        $this->lvbPossible = $values['lvbPossible'] ?? null;
        $this->commission = $values['commission'] ?? null;
        $this->markets = $values['markets'];
        $this->variantCodes = $values['variantCodes'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
