<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class KeywordRanking extends JsonSerializableType
{
    /**
     * @var string $keywordId
     */
    #[JsonProperty('keywordId')]
    public string $keywordId;

    /**
     * @var ?string $keyword Null when the product has no position on the term in the keywords endpoint.
     */
    #[JsonProperty('keyword')]
    public ?string $keyword;

    /**
     * @var array<RankPoint> $history
     */
    #[JsonProperty('history'), ArrayType([RankPoint::class])]
    public array $history;

    /**
     * @param array{
     *   keywordId: string,
     *   history: array<RankPoint>,
     *   keyword?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->keywordId = $values['keywordId'];
        $this->keyword = $values['keyword'] ?? null;
        $this->history = $values['history'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
