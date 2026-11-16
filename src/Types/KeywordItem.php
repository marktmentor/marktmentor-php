<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class KeywordItem extends JsonSerializableType
{
    /**
     * @var string $keywordId
     */
    #[JsonProperty('keywordId')]
    public string $keywordId;

    /**
     * @var ?string $keyword
     */
    #[JsonProperty('keyword')]
    public ?string $keyword;

    /**
     * @var KeywordMarkets $markets
     */
    #[JsonProperty('markets')]
    public KeywordMarkets $markets;

    /**
     * @param array{
     *   keywordId: string,
     *   markets: KeywordMarkets,
     *   keyword?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->keywordId = $values['keywordId'];
        $this->keyword = $values['keyword'] ?? null;
        $this->markets = $values['markets'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
