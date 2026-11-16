<?php

namespace MarktMentor\Niches\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Niches\Types\ProductDistributionsNichesRequestPeriod;

class ProductDistributionsNichesRequest extends JsonSerializableType
{
    /**
     * * `30d` - 30d
     * * `90d` - 90d
     * * `365d` - 365d
     *
     * @var ?value-of<ProductDistributionsNichesRequestPeriod> $period
     */
    public ?string $period;

    /**
     * @param array{
     *   period?: ?value-of<ProductDistributionsNichesRequestPeriod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->period = $values['period'] ?? null;
    }
}
