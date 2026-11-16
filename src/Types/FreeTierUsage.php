<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use DateTime;
use MarktMentor\Core\Types\Date;

class FreeTierUsage extends JsonSerializableType
{
    /**
     * @var bool $eligible True when the organization has an active paid MarktMentor Premium subscription.
     */
    #[JsonProperty('eligible')]
    public bool $eligible;

    /**
     * @var int $limit Free research requests per month.
     */
    #[JsonProperty('limit')]
    public int $limit;

    /**
     * @var int $used
     */
    #[JsonProperty('used')]
    public int $used;

    /**
     * @var int $remaining
     */
    #[JsonProperty('remaining')]
    public int $remaining;

    /**
     * @var int $pageSize Maximum results per page on free requests.
     */
    #[JsonProperty('pageSize')]
    public int $pageSize;

    /**
     * @var DateTime $resetsAt Start of the next calendar month (UTC).
     */
    #[JsonProperty('resetsAt'), Date(Date::TYPE_DATETIME)]
    public DateTime $resetsAt;

    /**
     * @param array{
     *   eligible: bool,
     *   limit: int,
     *   used: int,
     *   remaining: int,
     *   pageSize: int,
     *   resetsAt: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eligible = $values['eligible'];
        $this->limit = $values['limit'];
        $this->used = $values['used'];
        $this->remaining = $values['remaining'];
        $this->pageSize = $values['pageSize'];
        $this->resetsAt = $values['resetsAt'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
