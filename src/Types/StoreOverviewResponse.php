<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;
use DateTime;
use MarktMentor\Core\Types\Date;

class StoreOverviewResponse extends JsonSerializableType
{
    /**
     * @var CurrentPeriod $period
     */
    #[JsonProperty('period')]
    public CurrentPeriod $period;

    /**
     * @var Period $previousPeriod
     */
    #[JsonProperty('previousPeriod')]
    public Period $previousPeriod;

    /**
     * @var StoreFilters $filters
     */
    #[JsonProperty('filters')]
    public StoreFilters $filters;

    /**
     * @var StoreKpi $kpis
     */
    #[JsonProperty('kpis')]
    public StoreKpi $kpis;

    /**
     * @var StorePreviousKpi $previous
     */
    #[JsonProperty('previous')]
    public StorePreviousKpi $previous;

    /**
     * @var StoreChange $change The value of this period minus the value of the previous period.
     */
    #[JsonProperty('change')]
    public StoreChange $change;

    /**
     * @var StoreChange $changePct Each value is the change divided by the previous value. Percentage: 20.0 is +20%. A value is null when the previous value is zero or negative (a loss): a percentage of such a value has no meaning. Use change then.
     */
    #[JsonProperty('changePct')]
    public StoreChange $changePct;

    /**
     * @var DateTime $asOf
     */
    #[JsonProperty('asOf'), Date(Date::TYPE_DATETIME)]
    public DateTime $asOf;

    /**
     * @param array{
     *   period: CurrentPeriod,
     *   previousPeriod: Period,
     *   filters: StoreFilters,
     *   kpis: StoreKpi,
     *   previous: StorePreviousKpi,
     *   change: StoreChange,
     *   changePct: StoreChange,
     *   asOf: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->period = $values['period'];
        $this->previousPeriod = $values['previousPeriod'];
        $this->filters = $values['filters'];
        $this->kpis = $values['kpis'];
        $this->previous = $values['previous'];
        $this->change = $values['change'];
        $this->changePct = $values['changePct'];
        $this->asOf = $values['asOf'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
