<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class AllowanceError extends JsonSerializableType
{
    /**
     * Which allowance is used up. See the description of HTTP 402.
     *
     * * `bundle_exhausted` - bundle_exhausted
     * * `overage_limit_reached` - overage_limit_reached
     * * `free_quota_exhausted` - free_quota_exhausted
     *
     * @var value-of<AllowanceErrorCode> $code
     */
    #[JsonProperty('code')]
    public string $code;

    /**
     * @var string $detail
     */
    #[JsonProperty('detail')]
    public string $detail;

    /**
     * @param array{
     *   code: value-of<AllowanceErrorCode>,
     *   detail: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->code = $values['code'];
        $this->detail = $values['detail'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
