<?php

namespace MarktMentor\Store;

use Psr\Http\Client\ClientInterface;
use MarktMentor\Core\Client\RawClient;
use MarktMentor\Store\Requests\OverviewStoreRequest;
use MarktMentor\Types\StoreOverviewResponse;
use MarktMentor\Exceptions\MarktmentorException;
use MarktMentor\Exceptions\MarktmentorApiException;
use MarktMentor\Core\Json\JsonApiRequest;
use MarktMentor\Environments;
use MarktMentor\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use MarktMentor\Store\Requests\ProductsStoreRequest;
use MarktMentor\Core\Pagination\Pager;
use MarktMentor\Types\StorePerformanceProductPerformanceItem;
use MarktMentor\Core\Pagination\OffsetPager;
use MarktMentor\Types\StoreProductsResponse;
use MarktMentor\Store\Requests\InventoryStoreRequest;
use MarktMentor\Types\StoreInventoryRow;
use MarktMentor\Types\StoreInventoryResponse;
use MarktMentor\Core\Json\JsonSerializer;

class StoreClient
{
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
     * @param RawClient $client
     * @param ?array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        RawClient $client,
        ?array $options = null,
    ) {
        $this->client = $client;
        $this->options = $options ?? [];
    }

    /**
     * Get the revenue, costs, profit, orders, sales and returns of your own connected bol store for a period, compared with the period before.
     *
     * This request is free: it does not count as a research request.
     *
     * Example:
     * ```php
     * $client->store->overview(
     *     new OverviewStoreRequest([]),
     * );
     * ```
     *
     * @param OverviewStoreRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?StoreOverviewResponse
     * @throws MarktmentorException
     * @throws MarktmentorApiException
     */
    public function overview(OverviewStoreRequest $request = new OverviewStoreRequest(), ?array $options = null): ?StoreOverviewResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->country != null) {
            $query['country'] = $request->country;
        }
        if ($request->days != null) {
            $query['days'] = $request->days;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "api/public/v1/store/overview/",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return StoreOverviewResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktmentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktmentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktmentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * List the products of your own connected bol store that had orders in the period, with sales, revenue, costs and profit per product.
     *
     * This request is free: it does not count as a research request.
     *
     * Example:
     * ```php
     * $client->store->products(
     *     new ProductsStoreRequest([]),
     * );
     * ```
     *
     * @param ProductsStoreRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<StorePerformanceProductPerformanceItem>
     */
    public function products(ProductsStoreRequest $request = new ProductsStoreRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (ProductsStoreRequest $request) => $this->_products($request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (ProductsStoreRequest $request) => $request?->page ?? 0,
            setOffset: function (ProductsStoreRequest $request, int $offset) {
                $request->page = $offset;
            },
            getStep: null,
            /* @phpstan-ignore-next-line */
            getItems: fn (?StoreProductsResponse $response) => $response?->data ?? [],
            /* @phpstan-ignore-next-line */
            hasNextPage: fn (?StoreProductsResponse $response) => $response?->pagination?->hasNext,
        );
    }

    /**
     * List the active products of your own connected bol store with their stock and stock state.
     *
     * This request is free: it does not count as a research request.
     *
     * Example:
     * ```php
     * $client->store->inventory(
     *     new InventoryStoreRequest([
     *         'ean' => '5407005143414',
     *     ]),
     * );
     * ```
     *
     * @param InventoryStoreRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<StoreInventoryRow>
     */
    public function inventory(InventoryStoreRequest $request = new InventoryStoreRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (InventoryStoreRequest $request) => $this->_inventory($request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (InventoryStoreRequest $request) => $request?->page ?? 0,
            setOffset: function (InventoryStoreRequest $request, int $offset) {
                $request->page = $offset;
            },
            getStep: null,
            /* @phpstan-ignore-next-line */
            getItems: fn (?StoreInventoryResponse $response) => $response?->data ?? [],
            /* @phpstan-ignore-next-line */
            hasNextPage: fn (?StoreInventoryResponse $response) => $response?->pagination?->hasNext,
        );
    }

    /**
     * List the products of your own connected bol store that had orders in the period, with sales, revenue, costs and profit per product.
     *
     * This request is free: it does not count as a research request.
     *
     * @param ProductsStoreRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?StoreProductsResponse
     * @throws MarktmentorException
     * @throws MarktmentorApiException
     */
    private function _products(ProductsStoreRequest $request = new ProductsStoreRequest(), ?array $options = null): ?StoreProductsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->categoryId != null) {
            $query['categoryId'] = $request->categoryId;
        }
        if ($request->country != null) {
            $query['country'] = $request->country;
        }
        if ($request->days != null) {
            $query['days'] = $request->days;
        }
        if ($request->eans != null) {
            $query['eans'] = $request->eans;
        }
        if ($request->endDate != null) {
            $query['endDate'] = JsonSerializer::serializeDate($request->endDate);
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->pageSize != null) {
            $query['pageSize'] = $request->pageSize;
        }
        if ($request->sort != null) {
            $query['sort'] = $request->sort;
        }
        if ($request->startDate != null) {
            $query['startDate'] = JsonSerializer::serializeDate($request->startDate);
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "api/public/v1/store/products/",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return StoreProductsResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktmentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktmentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktmentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * List the active products of your own connected bol store with their stock and stock state.
     *
     * This request is free: it does not count as a research request.
     *
     * @param InventoryStoreRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?StoreInventoryResponse
     * @throws MarktmentorException
     * @throws MarktmentorApiException
     */
    private function _inventory(InventoryStoreRequest $request = new InventoryStoreRequest(), ?array $options = null): ?StoreInventoryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->ean != null) {
            $query['ean'] = $request->ean;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->pageSize != null) {
            $query['pageSize'] = $request->pageSize;
        }
        if ($request->stockState != null) {
            $query['stockState'] = $request->stockState;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "api/public/v1/store/inventory/",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return StoreInventoryResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktmentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktmentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktmentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }
}
