<?php

namespace MarktMentor\Store\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Store\Types\ProductsStoreRequestCountry;
use DateTime;
use MarktMentor\Store\Types\ProductsStoreRequestSort;

class ProductsStoreRequest extends JsonSerializableType
{
    /**
     * @var ?int $categoryId Only products in this bol category or in a category below it. The same identifier as `categoryId` in the research filters; find it with List categories.
     */
    public ?int $categoryId;

    /**
     * NL or BE. Without this parameter: both countries.
     *
     * * `NL` - NL
     * * `BE` - BE
     *
     * @var ?value-of<ProductsStoreRequestCountry> $country
     */
    public ?string $country;

    /**
     * @var ?int $days The last N days, today included. Do not combine with startDate and endDate.
     */
    public ?int $days;

    /**
     * @var ?string $eans EANs, separated by commas (maximum 100). With this filter, the page is in the sequence of sales (high to low) and `sort` only selects the products.
     */
    public ?string $eans;

    /**
     * @var ?DateTime $endDate Last day of the period (YYYY-MM-DD), included.
     */
    public ?DateTime $endDate;

    /**
     * @var ?int $page Page number, from 1 to 100.
     */
    public ?int $page;

    /**
     * Results per page: 5, 10, 25, 50 or 100.
     *
     * * `5` - 5
     * * `10` - 10
     * * `25` - 25
     * * `50` - 50
     * * `100` - 100
     *
     * @var ?int $pageSize
     */
    public ?int $pageSize;

    /**
     * Sort field; a `-` prefix gives high to low. Selection and sequence use the order amounts before the final cost adjustments (advertising, storage, returns). Thus the sequence can be different from the sequence of `totalCosts` or `totalProfits`.
     *
     * * `revenue` - revenue
     * * `-revenue` - -revenue
     * * `sales` - sales
     * * `-sales` - -sales
     * * `costs` - costs
     * * `-costs` - -costs
     * * `profits` - profits
     * * `-profits` - -profits
     *
     * @var ?value-of<ProductsStoreRequestSort> $sort
     */
    public ?string $sort;

    /**
     * @var ?DateTime $startDate First day of the period (YYYY-MM-DD). Send it together with endDate. The period can be at most 366 days.
     */
    public ?DateTime $startDate;

    /**
     * @param array{
     *   categoryId?: ?int,
     *   country?: ?value-of<ProductsStoreRequestCountry>,
     *   days?: ?int,
     *   eans?: ?string,
     *   endDate?: ?DateTime,
     *   page?: ?int,
     *   pageSize?: ?int,
     *   sort?: ?value-of<ProductsStoreRequestSort>,
     *   startDate?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->categoryId = $values['categoryId'] ?? null;
        $this->country = $values['country'] ?? null;
        $this->days = $values['days'] ?? null;
        $this->eans = $values['eans'] ?? null;
        $this->endDate = $values['endDate'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->pageSize = $values['pageSize'] ?? null;
        $this->sort = $values['sort'] ?? null;
        $this->startDate = $values['startDate'] ?? null;
    }
}
