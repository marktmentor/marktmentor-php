<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class StorePerformanceSalesCostsBreakdown extends JsonSerializableType
{
    /**
     * @var float $shippingCosts
     */
    #[JsonProperty('shippingCosts')]
    public float $shippingCosts;

    /**
     * @var float $surcharge
     */
    #[JsonProperty('surcharge')]
    public float $surcharge;

    /**
     * @var float $productCosts
     */
    #[JsonProperty('productCosts')]
    public float $productCosts;

    /**
     * @var float $surchargeRefunds
     */
    #[JsonProperty('surchargeRefunds')]
    public float $surchargeRefunds;

    /**
     * @var float $shippingLabelRefunds
     */
    #[JsonProperty('shippingLabelRefunds')]
    public float $shippingLabelRefunds;

    /**
     * @var float $commission
     */
    #[JsonProperty('commission')]
    public float $commission;

    /**
     * @var float $commissionCorrection
     */
    #[JsonProperty('commissionCorrection')]
    public float $commissionCorrection;

    /**
     * @var float $compensation
     */
    #[JsonProperty('compensation')]
    public float $compensation;

    /**
     * @param array{
     *   shippingCosts: float,
     *   surcharge: float,
     *   productCosts: float,
     *   surchargeRefunds: float,
     *   shippingLabelRefunds: float,
     *   commission: float,
     *   commissionCorrection: float,
     *   compensation: float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->shippingCosts = $values['shippingCosts'];
        $this->surcharge = $values['surcharge'];
        $this->productCosts = $values['productCosts'];
        $this->surchargeRefunds = $values['surchargeRefunds'];
        $this->shippingLabelRefunds = $values['shippingLabelRefunds'];
        $this->commission = $values['commission'];
        $this->commissionCorrection = $values['commissionCorrection'];
        $this->compensation = $values['compensation'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
