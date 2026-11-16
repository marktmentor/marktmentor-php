<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Products\Types\ReviewsProductsRequestMarket;
use MarktMentor\Products\Types\ReviewsProductsRequestPeriod;
use MarktMentor\Products\Types\ReviewsProductsRequestSort;

class ReviewsProductsRequest extends JsonSerializableType
{
    /**
     * @var ?bool $includeVariants true (the default): also the reviews written for other variants of the same product family, as bol shows them on the product page. false: only the reviews written for this product. productCode of each review says for which product it was written.
     */
    public ?bool $includeVariants;

    /**
     * @var ?value-of<ReviewsProductsRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
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
     * * `3M` - 3M
     * * `6M` - 6M
     * * `1Y` - 1Y
     * * `2Y` - 2Y
     *
     * @var ?value-of<ReviewsProductsRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @var ?int $score
     */
    public ?int $score;

    /**
     * @var ?string $search Text to search for. In product lists, all words must match; the search also matches seller names, EANs and product codes. In review lists, each word must occur in the review text; upper and lower case do not matter.
     */
    public ?string $search;

    /**
     * * `date` - date
     * * `-date` - -date
     * * `score` - score
     * * `-score` - -score
     *
     * @var ?value-of<ReviewsProductsRequestSort> $sort
     */
    public ?string $sort;

    /**
     * @var ?bool $verified
     */
    public ?bool $verified;

    /**
     * @param array{
     *   includeVariants?: ?bool,
     *   market?: ?value-of<ReviewsProductsRequestMarket>,
     *   page?: ?int,
     *   pageSize?: ?int,
     *   period?: ?value-of<ReviewsProductsRequestPeriod>,
     *   score?: ?int,
     *   search?: ?string,
     *   sort?: ?value-of<ReviewsProductsRequestSort>,
     *   verified?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->includeVariants = $values['includeVariants'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->pageSize = $values['pageSize'] ?? null;
        $this->period = $values['period'] ?? null;
        $this->score = $values['score'] ?? null;
        $this->search = $values['search'] ?? null;
        $this->sort = $values['sort'] ?? null;
        $this->verified = $values['verified'] ?? null;
    }
}
