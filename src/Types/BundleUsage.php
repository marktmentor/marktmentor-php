<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use DateTime;
use MarktMentor\Core\Types\Date;

class BundleUsage extends JsonSerializableType
{
    /**
     * @var int $includedRequests Requests included in the current billing period.
     */
    #[JsonProperty('includedRequests')]
    public int $includedRequests;

    /**
     * @var int $usedRequests Successful research requests charged in this period.
     */
    #[JsonProperty('usedRequests')]
    public int $usedRequests;

    /**
     * @var int $remainingRequests Included requests left in this period.
     */
    #[JsonProperty('remainingRequests')]
    public int $remainingRequests;

    /**
     * @var int $additionalRequests Requests above the included amount, billed at €0.05 each.
     */
    #[JsonProperty('additionalRequests')]
    public int $additionalRequests;

    /**
     * @var int $additionalRequestsLimitAmount Most the organization pays for requests above the bundle in one billing period, in euro cents. 0 (the default): requests stop when the bundle is used up and return 402 `bundle_exhausted`. Above 0: extra requests are allowed up to this amount, then return 402 `overage_limit_reached`.
     */
    #[JsonProperty('additionalRequestsLimitAmount')]
    public int $additionalRequestsLimitAmount;

    /**
     * @var DateTime $periodStart
     */
    #[JsonProperty('periodStart'), Date(Date::TYPE_DATETIME)]
    public DateTime $periodStart;

    /**
     * @var DateTime $periodEnd The included requests reset at this time.
     */
    #[JsonProperty('periodEnd'), Date(Date::TYPE_DATETIME)]
    public DateTime $periodEnd;

    /**
     * @param array{
     *   includedRequests: int,
     *   usedRequests: int,
     *   remainingRequests: int,
     *   additionalRequests: int,
     *   additionalRequestsLimitAmount: int,
     *   periodStart: DateTime,
     *   periodEnd: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->includedRequests = $values['includedRequests'];
        $this->usedRequests = $values['usedRequests'];
        $this->remainingRequests = $values['remainingRequests'];
        $this->additionalRequests = $values['additionalRequests'];
        $this->additionalRequestsLimitAmount = $values['additionalRequestsLimitAmount'];
        $this->periodStart = $values['periodStart'];
        $this->periodEnd = $values['periodEnd'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
