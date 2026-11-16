<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use MarktMentor\Core\Types\ArrayType;

class NicheDetail extends JsonSerializableType
{
    /**
     * @var string $nicheId
     */
    #[JsonProperty('nicheId')]
    public string $nicheId;

    /**
     * @var string $name
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var ?int $productCount
     */
    #[JsonProperty('productCount')]
    public ?int $productCount;

    /**
     * @var ?float $qualityScore Score from 0 to 10. Not a percentage.
     */
    #[JsonProperty('qualityScore')]
    public ?float $qualityScore;

    /**
     * @var ?float $competitionScore Score from 0 to 10. Not a percentage.
     */
    #[JsonProperty('competitionScore')]
    public ?float $competitionScore;

    /**
     * @var NicheMarkets $markets
     */
    #[JsonProperty('markets')]
    public NicheMarkets $markets;

    /**
     * @var ?array<NichePeriod> $periods
     */
    #[JsonProperty('periods'), ArrayType([NichePeriod::class])]
    public ?array $periods;

    /**
     * @param array{
     *   nicheId: string,
     *   name: string,
     *   markets: NicheMarkets,
     *   productCount?: ?int,
     *   qualityScore?: ?float,
     *   competitionScore?: ?float,
     *   periods?: ?array<NichePeriod>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->nicheId = $values['nicheId'];
        $this->name = $values['name'];
        $this->productCount = $values['productCount'] ?? null;
        $this->qualityScore = $values['qualityScore'] ?? null;
        $this->competitionScore = $values['competitionScore'] ?? null;
        $this->markets = $values['markets'];
        $this->periods = $values['periods'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
