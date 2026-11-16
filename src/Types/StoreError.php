<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class StoreError extends JsonSerializableType
{
    /**
     * @var string $code
     */
    #[JsonProperty('code')]
    public string $code;

    /**
     * @var string $detail
     */
    #[JsonProperty('detail')]
    public string $detail;

    /**
     * @var ?array<string, mixed> $errors
     */
    #[JsonProperty('errors'), ArrayType(['string' => 'mixed'])]
    public ?array $errors;

    /**
     * @param array{
     *   code: string,
     *   detail: string,
     *   errors?: ?array<string, mixed>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->code = $values['code'];
        $this->detail = $values['detail'];
        $this->errors = $values['errors'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
