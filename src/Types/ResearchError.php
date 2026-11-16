<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class ResearchError extends JsonSerializableType
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
     * @var ?array<array<string, mixed>> $candidates
     */
    #[JsonProperty('candidates'), ArrayType([['string' => 'mixed']])]
    public ?array $candidates;

    /**
     * @param array{
     *   code: string,
     *   detail: string,
     *   errors?: ?array<string, mixed>,
     *   candidates?: ?array<array<string, mixed>>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->code = $values['code'];
        $this->detail = $values['detail'];
        $this->errors = $values['errors'] ?? null;
        $this->candidates = $values['candidates'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
