<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class StorePerformanceProductPerformanceItem extends JsonSerializableType
{
    /**
     * @var ?string $title
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * @var string $ean
     */
    #[JsonProperty('ean')]
    public string $ean;

    /**
     * @var ?bool $inSelectedStore
     */
    #[JsonProperty('inSelectedStore')]
    public ?bool $inSelectedStore;

    /**
     * @var ?string $image
     */
    #[JsonProperty('image')]
    public ?string $image;

    /**
     * @var ?float $reviewScore Average review rating, in stars from 1 to 5. 0 without reviews.
     */
    #[JsonProperty('reviewScore')]
    public ?float $reviewScore;

    /**
     * @var ?int $reviewCount
     */
    #[JsonProperty('reviewCount')]
    public ?int $reviewCount;

    /**
     * @var ?string $productLink
     */
    #[JsonProperty('productLink')]
    public ?string $productLink;

    /**
     * @var ?string $productCode
     */
    #[JsonProperty('productCode')]
    public ?string $productCode;

    /**
     * @var ?float $sales
     */
    #[JsonProperty('sales')]
    public ?float $sales;

    /**
     * @var ?float $orders
     */
    #[JsonProperty('orders')]
    public ?float $orders;

    /**
     * @var ?float $revenue
     */
    #[JsonProperty('revenue')]
    public ?float $revenue;

    /**
     * @var ?float $netRevenue
     */
    #[JsonProperty('netRevenue')]
    public ?float $netRevenue;

    /**
     * @var ?float $commission
     */
    #[JsonProperty('commission')]
    public ?float $commission;

    /**
     * @var ?float $totalCosts
     */
    #[JsonProperty('totalCosts')]
    public ?float $totalCosts;

    /**
     * @var ?float $salesCosts
     */
    #[JsonProperty('salesCosts')]
    public ?float $salesCosts;

    /**
     * @var ?StorePerformanceSalesCostsBreakdown $salesCostsBreakdown
     */
    #[JsonProperty('salesCostsBreakdown')]
    public ?StorePerformanceSalesCostsBreakdown $salesCostsBreakdown;

    /**
     * @var ?float $salesProfits
     */
    #[JsonProperty('salesProfits')]
    public ?float $salesProfits;

    /**
     * @var ?float $salesProfitMargin Profit on sales divided by the revenue. Percentage: 25.0 is 25%.
     */
    #[JsonProperty('salesProfitMargin')]
    public ?float $salesProfitMargin;

    /**
     * @var ?float $salesRoi Profit on sales divided by the sales costs. Percentage: 25.0 is 25%; it can be above 100.
     */
    #[JsonProperty('salesRoi')]
    public ?float $salesRoi;

    /**
     * @var ?float $returns
     */
    #[JsonProperty('returns')]
    public ?float $returns;

    /**
     * @var ?float $returnCosts
     */
    #[JsonProperty('returnCosts')]
    public ?float $returnCosts;

    /**
     * @var ?StorePerformanceReturnCostsBreakdown $returnCostsBreakdown
     */
    #[JsonProperty('returnCostsBreakdown')]
    public ?StorePerformanceReturnCostsBreakdown $returnCostsBreakdown;

    /**
     * @var ?float $totalProfits
     */
    #[JsonProperty('totalProfits')]
    public ?float $totalProfits;

    /**
     * @var ?float $totalMargin Total profit (after returns, advertising and storage) divided by the net revenue. Percentage: 25.0 is 25%. For a row without returns, advertising and storage costs the divisor can be the revenue.
     */
    #[JsonProperty('totalMargin')]
    public ?float $totalMargin;

    /**
     * @var ?float $totalRoi Total profit divided by the total costs. Percentage: 25.0 is 25%; it can be above 100.
     */
    #[JsonProperty('totalRoi')]
    public ?float $totalRoi;

    /**
     * @var ?float $clicks
     */
    #[JsonProperty('clicks')]
    public ?float $clicks;

    /**
     * @var ?float $conversion Orders divided by the visits (clicks). Percentage: 5.0 is 5%.
     */
    #[JsonProperty('conversion')]
    public ?float $conversion;

    /**
     * @var ?float $conversionBenchmark Conversion of the product group. Percentage: 6.4 is 6.4%, the same unit as conversion. Null when there is no benchmark.
     */
    #[JsonProperty('conversionBenchmark')]
    public ?float $conversionBenchmark;

    /**
     * @var ?float $adCost
     */
    #[JsonProperty('adCost')]
    public ?float $adCost;

    /**
     * @var ?float $acos Advertising cost divided by the advertising revenue. Percentage: 8.0 is 8%; it can be above 100. The advertising cost of today is left out, because there is no advertising revenue for today yet; adCost includes today. 0 without advertising revenue.
     */
    #[JsonProperty('acos')]
    public ?float $acos;

    /**
     * @var ?float $tacos Advertising cost divided by the total revenue. Percentage: 4.0 is 4%.
     */
    #[JsonProperty('tacos')]
    public ?float $tacos;

    /**
     * @var ?bool $isActive
     */
    #[JsonProperty('isActive')]
    public ?bool $isActive;

    /**
     * @var ?float $storageCosts
     */
    #[JsonProperty('storageCosts')]
    public ?float $storageCosts;

    /**
     * @var ?float $gradedStorageCosts
     */
    #[JsonProperty('gradedStorageCosts')]
    public ?float $gradedStorageCosts;

    /**
     * @var bool $hasProductCosts False when no purchase price is known for the EAN, or when costs are hidden. The profit is then the revenue minus bol costs only.
     */
    #[JsonProperty('hasProductCosts')]
    public bool $hasProductCosts;

    /**
     * @param array{
     *   ean: string,
     *   hasProductCosts: bool,
     *   title?: ?string,
     *   inSelectedStore?: ?bool,
     *   image?: ?string,
     *   reviewScore?: ?float,
     *   reviewCount?: ?int,
     *   productLink?: ?string,
     *   productCode?: ?string,
     *   sales?: ?float,
     *   orders?: ?float,
     *   revenue?: ?float,
     *   netRevenue?: ?float,
     *   commission?: ?float,
     *   totalCosts?: ?float,
     *   salesCosts?: ?float,
     *   salesCostsBreakdown?: ?StorePerformanceSalesCostsBreakdown,
     *   salesProfits?: ?float,
     *   salesProfitMargin?: ?float,
     *   salesRoi?: ?float,
     *   returns?: ?float,
     *   returnCosts?: ?float,
     *   returnCostsBreakdown?: ?StorePerformanceReturnCostsBreakdown,
     *   totalProfits?: ?float,
     *   totalMargin?: ?float,
     *   totalRoi?: ?float,
     *   clicks?: ?float,
     *   conversion?: ?float,
     *   conversionBenchmark?: ?float,
     *   adCost?: ?float,
     *   acos?: ?float,
     *   tacos?: ?float,
     *   isActive?: ?bool,
     *   storageCosts?: ?float,
     *   gradedStorageCosts?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->title = $values['title'] ?? null;
        $this->ean = $values['ean'];
        $this->inSelectedStore = $values['inSelectedStore'] ?? null;
        $this->image = $values['image'] ?? null;
        $this->reviewScore = $values['reviewScore'] ?? null;
        $this->reviewCount = $values['reviewCount'] ?? null;
        $this->productLink = $values['productLink'] ?? null;
        $this->productCode = $values['productCode'] ?? null;
        $this->sales = $values['sales'] ?? null;
        $this->orders = $values['orders'] ?? null;
        $this->revenue = $values['revenue'] ?? null;
        $this->netRevenue = $values['netRevenue'] ?? null;
        $this->commission = $values['commission'] ?? null;
        $this->totalCosts = $values['totalCosts'] ?? null;
        $this->salesCosts = $values['salesCosts'] ?? null;
        $this->salesCostsBreakdown = $values['salesCostsBreakdown'] ?? null;
        $this->salesProfits = $values['salesProfits'] ?? null;
        $this->salesProfitMargin = $values['salesProfitMargin'] ?? null;
        $this->salesRoi = $values['salesRoi'] ?? null;
        $this->returns = $values['returns'] ?? null;
        $this->returnCosts = $values['returnCosts'] ?? null;
        $this->returnCostsBreakdown = $values['returnCostsBreakdown'] ?? null;
        $this->totalProfits = $values['totalProfits'] ?? null;
        $this->totalMargin = $values['totalMargin'] ?? null;
        $this->totalRoi = $values['totalRoi'] ?? null;
        $this->clicks = $values['clicks'] ?? null;
        $this->conversion = $values['conversion'] ?? null;
        $this->conversionBenchmark = $values['conversionBenchmark'] ?? null;
        $this->adCost = $values['adCost'] ?? null;
        $this->acos = $values['acos'] ?? null;
        $this->tacos = $values['tacos'] ?? null;
        $this->isActive = $values['isActive'] ?? null;
        $this->storageCosts = $values['storageCosts'] ?? null;
        $this->gradedStorageCosts = $values['gradedStorageCosts'] ?? null;
        $this->hasProductCosts = $values['hasProductCosts'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
