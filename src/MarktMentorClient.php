<?php

namespace MarktMentor;

use MarktMentor\Products\ProductsClient;
use MarktMentor\Niches\NichesClient;
use MarktMentor\Reference\ReferenceClient;
use MarktMentor\Organization\OrganizationClient;
use MarktMentor\Usage\UsageClient;
use MarktMentor\Store\StoreClient;
use Psr\Http\Client\ClientInterface;
use MarktMentor\Core\Client\RawClient;

class MarktMentorClient
{
    /**
     * @var ProductsClient $products
     */
    public ProductsClient $products;

    /**
     * @var NichesClient $niches
     */
    public NichesClient $niches;

    /**
     * @var ReferenceClient $reference
     */
    public ReferenceClient $reference;

    /**
     * @var OrganizationClient $organization
     */
    public OrganizationClient $organization;

    /**
     * @var UsageClient $usage
     */
    public UsageClient $usage;

    /**
     * @var StoreClient $store
     */
    public StoreClient $store;

    /**
     * @var array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options @phpstan-ignore-next-line Property is used in endpoint methods via HttpEndpointGenerator
     */
    private array $options;

    /**
     * @var RawClient $client
     */
    private RawClient $client;

    /**
     * @param string $token The token to use for authentication.
     * @param ?array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        string $token,
        ?array $options = null,
    ) {
        $defaultHeaders = [
            'Authorization' => "Bearer $token",
            'X-Fern-Language' => 'PHP',
            'X-Fern-SDK-Name' => 'MarktMentor',
            'X-Fern-SDK-Version' => '0.1.1',
            'User-Agent' => 'marktmentor/api/0.1.1',
        ];

        $this->options = $options ?? [];

        $this->options['headers'] = array_merge(
            $defaultHeaders,
            $this->options['headers'] ?? [],
        );

        $this->client = new RawClient(
            options: $this->options,
        );

        $this->products = new ProductsClient($this->client, $this->options);
        $this->niches = new NichesClient($this->client, $this->options);
        $this->reference = new ReferenceClient($this->client, $this->options);
        $this->organization = new OrganizationClient($this->client, $this->options);
        $this->usage = new UsageClient($this->client, $this->options);
        $this->store = new StoreClient($this->client, $this->options);
    }
}
