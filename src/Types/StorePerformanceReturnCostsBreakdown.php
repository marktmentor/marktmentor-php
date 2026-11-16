<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class StorePerformanceReturnCostsBreakdown extends JsonSerializableType
{
    /**
     * @var float $otherReturnCosts
     */
    #[JsonProperty('otherReturnCosts')]
    public float $otherReturnCosts;

    /**
     * @var float $returnLabelCost
     */
    #[JsonProperty('returnLabelCost')]
    public float $returnLabelCost;

    /**
     * @var float $productLostLeniency
     */
    #[JsonProperty('productLostLeniency')]
    public float $productLostLeniency;

    /**
     * @var float $otherCompensation
     */
    #[JsonProperty('otherCompensation')]
    public float $otherCompensation;

    /**
     * @var float $commissionCorrection
     */
    #[JsonProperty('commissionCorrection')]
    public float $commissionCorrection;

    /**
     * @var float $revenueCorrection
     */
    #[JsonProperty('revenueCorrection')]
    public float $revenueCorrection;

    /**
     * @var float $shipAdditionalProducts
     */
    #[JsonProperty('shipAdditionalProducts')]
    public float $shipAdditionalProducts;

    /**
     * @var float $productsBackInStockCorrection
     */
    #[JsonProperty('productsBackInStockCorrection')]
    public float $productsBackInStockCorrection;

    /**
     * @param array{
     *   otherReturnCosts: float,
     *   returnLabelCost: float,
     *   productLostLeniency: float,
     *   otherCompensation: float,
     *   commissionCorrection: float,
     *   revenueCorrection: float,
     *   shipAdditionalProducts: float,
     *   productsBackInStockCorrection: float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->otherReturnCosts = $values['otherReturnCosts'];
        $this->returnLabelCost = $values['returnLabelCost'];
        $this->productLostLeniency = $values['productLostLeniency'];
        $this->otherCompensation = $values['otherCompensation'];
        $this->commissionCorrection = $values['commissionCorrection'];
        $this->revenueCorrection = $values['revenueCorrection'];
        $this->shipAdditionalProducts = $values['shipAdditionalProducts'];
        $this->productsBackInStockCorrection = $values['productsBackInStockCorrection'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
