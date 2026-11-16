<?php

namespace MarktMentor\Store\Requests;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Store\Types\OverviewStoreRequestCountry;

class OverviewStoreRequest extends JsonSerializableType
{
    /**
     * * `NL` - NL
     * * `BE` - BE
     *
     * @var ?value-of<OverviewStoreRequestCountry> $country
     */
    public ?string $country;

    /**
     * @var ?int $days
     */
    public ?int $days;

    /**
     * @param array{
     *   country?: ?value-of<OverviewStoreRequestCountry>,
     *   days?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->country = $values['country'] ?? null;
        $this->days = $values['days'] ?? null;
    }
}
