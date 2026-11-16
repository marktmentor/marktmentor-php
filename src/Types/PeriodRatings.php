<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class PeriodRatings extends JsonSerializableType
{
    /**
     * @var ?int $_1
     */
    #[JsonProperty('1')]
    public ?int $_1;

    /**
     * @var ?int $_2
     */
    #[JsonProperty('2')]
    public ?int $_2;

    /**
     * @var ?int $_3
     */
    #[JsonProperty('3')]
    public ?int $_3;

    /**
     * @var ?int $_4
     */
    #[JsonProperty('4')]
    public ?int $_4;

    /**
     * @var ?int $_5
     */
    #[JsonProperty('5')]
    public ?int $_5;

    /**
     * @param array{
     *   _1?: ?int,
     *   _2?: ?int,
     *   _3?: ?int,
     *   _4?: ?int,
     *   _5?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->_1 = $values['_1'] ?? null;
        $this->_2 = $values['_2'] ?? null;
        $this->_3 = $values['_3'] ?? null;
        $this->_4 = $values['_4'] ?? null;
        $this->_5 = $values['_5'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
