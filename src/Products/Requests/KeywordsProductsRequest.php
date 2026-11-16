<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Products\Types\KeywordsProductsRequestMarket;
use MarktMentor\Products\Types\KeywordsProductsRequestPeriod;

class KeywordsProductsRequest extends JsonSerializableType
{
    /**
     * @var ?value-of<KeywordsProductsRequestMarket> $market NL for the Netherlands, BE for Belgium, or ALL for both markets. Reviews support ALL only.
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
     * * `7d` - 7d
     * * `30d` - 30d
     * * `90d` - 90d
     *
     * @var ?value-of<KeywordsProductsRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   market?: ?value-of<KeywordsProductsRequestMarket>,
     *   page?: ?int,
     *   pageSize?: ?int,
     *   period?: ?value-of<KeywordsProductsRequestPeriod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->pageSize = $values['pageSize'] ?? null;
        $this->period = $values['period'] ?? null;
    }
}
