<?php

namespace MarktMentor\Niches\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Niches\Types\ListNichesRequestMarket;
use MarktMentor\Niches\Types\ListNichesRequestPeriod;
use MarktMentor\Niches\Types\ListNichesRequestSort;

class ListNichesRequest extends JsonSerializableType
{
    /**
     * @var ?int $categoryId Filter by a bol category identifier. Find it with List categories, or copy it from `categories` of a product.
     */
    public ?int $categoryId;

    /**
     * @var ?value-of<ListNichesRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
     */
    public ?string $market;

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
     * @var ?value-of<ListNichesRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @var ?string $search Text to search for. In product lists, all words must match; the search also matches seller names, EANs and product codes. In review lists, each word must occur in the review text; upper and lower case do not matter.
     */
    public ?string $search;

    /**
     * * `revenue` - revenue
     * * `-revenue` - -revenue
     * * `volume` - volume
     * * `-volume` - -volume
     * * `products` - products
     * * `-products` - -products
     *
     * @var ?value-of<ListNichesRequestSort> $sort
     */
    public ?string $sort;

    /**
     * @param array{
     *   categoryId?: ?int,
     *   market?: ?value-of<ListNichesRequestMarket>,
     *   page?: ?int,
     *   pageSize?: ?int,
     *   period?: ?value-of<ListNichesRequestPeriod>,
     *   search?: ?string,
     *   sort?: ?value-of<ListNichesRequestSort>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->categoryId = $values['categoryId'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->pageSize = $values['pageSize'] ?? null;
        $this->period = $values['period'] ?? null;
        $this->search = $values['search'] ?? null;
        $this->sort = $values['sort'] ?? null;
    }
}
