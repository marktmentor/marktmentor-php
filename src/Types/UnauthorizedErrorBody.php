<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class UnauthorizedErrorBody extends JsonSerializableType
{
    /**
     * @var string $detail
     */
    #[JsonProperty('detail')]
    public string $detail;

    /**
     * @param array{
     *   detail: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
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
