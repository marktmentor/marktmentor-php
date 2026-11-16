<?php

namespace MarktMentor\Niches\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Niches\Types\ProductsNichesRequestMarket;
use MarktMentor\Niches\Types\ProductsNichesRequestPeriod;
use MarktMentor\Niches\Types\ProductsNichesRequestSort;

class ProductsNichesRequest extends JsonSerializableType
{
    /**
     * @var ?string $brand Filter by brand name. The match is exact, upper and lower case included. Find the name with Search brands, or copy `brand` from a product.
     */
    public ?string $brand;

    /**
     * @var ?int $categoryId Filter by a bol category identifier. Find it with List categories, or copy it from `categories` of a product.
     */
    public ?int $categoryId;

    /**
     * @var ?string $ean Filter by a 13-digit EAN, including matching product variants.
     */
    public ?string $ean;

    /**
     * @var ?value-of<ProductsNichesRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

    /**
     * @var ?float $maxPrice
     */
    public ?float $maxPrice;

    /**
     * @var ?float $maxRating
     */
    public ?float $maxRating;

    /**
     * @var ?float $maxRevenue
     */
    public ?float $maxRevenue;

    /**
     * @var ?float $maxSales
     */
    public ?float $maxSales;

    /**
     * @var ?float $minPrice
     */
    public ?float $minPrice;

    /**
     * @var ?float $minRating
     */
    public ?float $minRating;

    /**
     * @var ?float $minRevenue
     */
    public ?float $minRevenue;

    /**
     * @var ?float $minSales
     */
    public ?float $minSales;

    /**
     * @var ?int $page Page number, starting at 1.
     */
    public ?int $page;

    /**
     * @var ?int $pageSize Results per page (maximum 25). A successful page counts as one request. For each query, page × pageSize must not be more than 10,000; make the query narrower with filters to reach other results.
     */
    public ?int $pageSize;

    /**
     * * `30d` - 30d
     * * `90d` - 90d
     * * `365d` - 365d
     *
     * @var ?value-of<ProductsNichesRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @var ?string $search Text to search for. In product lists, all words must match; the search also matches seller names, EANs and product codes. In review lists, each word must occur in the review text; upper and lower case do not matter.
     */
    public ?string $search;

    /**
     * * `sales` - sales
     * * `-sales` - -sales
     * * `revenue` - revenue
     * * `-revenue` - -revenue
     * * `price` - price
     * * `-price` - -price
     *
     * @var ?value-of<ProductsNichesRequestSort> $sort
     */
    public ?string $sort;

    /**
     * @param array{
     *   brand?: ?string,
     *   categoryId?: ?int,
     *   ean?: ?string,
     *   market?: ?value-of<ProductsNichesRequestMarket>,
     *   maxPrice?: ?float,
     *   maxRating?: ?float,
     *   maxRevenue?: ?float,
     *   maxSales?: ?float,
     *   minPrice?: ?float,
     *   minRating?: ?float,
     *   minRevenue?: ?float,
     *   minSales?: ?float,
     *   page?: ?int,
     *   pageSize?: ?int,
     *   period?: ?value-of<ProductsNichesRequestPeriod>,
     *   search?: ?string,
     *   sort?: ?value-of<ProductsNichesRequestSort>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->brand = $values['brand'] ?? null;
        $this->categoryId = $values['categoryId'] ?? null;
        $this->ean = $values['ean'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->maxPrice = $values['maxPrice'] ?? null;
        $this->maxRating = $values['maxRating'] ?? null;
        $this->maxRevenue = $values['maxRevenue'] ?? null;
        $this->maxSales = $values['maxSales'] ?? null;
        $this->minPrice = $values['minPrice'] ?? null;
        $this->minRating = $values['minRating'] ?? null;
        $this->minRevenue = $values['minRevenue'] ?? null;
        $this->minSales = $values['minSales'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->pageSize = $values['pageSize'] ?? null;
        $this->period = $values['period'] ?? null;
        $this->search = $values['search'] ?? null;
        $this->sort = $values['sort'] ?? null;
    }
}
