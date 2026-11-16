<?php

namespace MarktMentor\Products\Requests;

use MarktMentor\Core\Json\JsonSerializableType;

class ReviewSummaryProductsRequest extends JsonSerializableType
{
    /**
     * @var ?bool $includeVariants true (the default): also the reviews written for other variants of the same product family, as bol shows them on the product page. false: only the reviews written for this product. productCode of each review says for which product it was written.
     */
    public ?bool $includeVariants;

    /**
     * @param array{
     *   includeVariants?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->includeVariants = $values['includeVariants'] ?? null;
    }
}
