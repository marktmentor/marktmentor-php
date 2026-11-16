<?php

namespace MarktMentor\Reference;

use Psr\Http\Client\ClientInterface;
use MarktMentor\Core\Client\RawClient;
use MarktMentor\Reference\Requests\CategoriesReferenceRequest;
use MarktMentor\Core\Pagination\Pager;
use MarktMentor\Types\Category;
use MarktMentor\Core\Pagination\OffsetPager;
use MarktMentor\Types\CategoryListResponse;
use MarktMentor\Types\CategoryResponse;
use MarktMentor\Exceptions\MarktmentorException;
use MarktMentor\Exceptions\MarktmentorApiException;
use MarktMentor\Core\Json\JsonApiRequest;
use MarktMentor\Environments;
use MarktMentor\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use MarktMentor\Reference\Requests\BrandsReferenceRequest;
use MarktMentor\Types\BrandListResponse;

class ReferenceClient
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
     * The bol category tree. Use it to find the `categoryId` for the product, niche and store filters. Send `level=1` for the top of the tree, `parentId` for the categories below one category, or `search` to find a category by name. Without a filter you get all categories, in the order of the tree.
     *
     * This request is free: it does not count as a research request.
     *
     * Example:
     * ```php
     * $client->reference->categories(
     *     new CategoriesReferenceRequest([
     *         'search' => 'drinkfles',
     *     ]),
     * );
     * ```
     *
     * @param CategoriesReferenceRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<Category>
     */
    public function categories(CategoriesReferenceRequest $request = new CategoriesReferenceRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (CategoriesReferenceRequest $request) => $this->_categories($request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (CategoriesReferenceRequest $request) => $request?->page ?? 0,
            setOffset: function (CategoriesReferenceRequest $request, int $offset) {
                $request->page = $offset;
            },
            getStep: null,
            /* @phpstan-ignore-next-line */
            getItems: fn (?CategoryListResponse $response) => $response?->data ?? [],
            /* @phpstan-ignore-next-line */
            hasNextPage: fn (?CategoryListResponse $response) => $response?->pagination?->hasNext,
        );
    }

    /**
     * One category with its level, its parent and its path. Use it to show the name and the path of a `categoryId` that you already have.
     *
     * This request is free: it does not count as a research request.
     *
     * Example:
     * ```php
     * $client->reference->category(
     *     1,
     * );
     * ```
     *
     * @param int $categoryId Category identifier, returned as categoryId.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?CategoryResponse
     * @throws MarktmentorException
     * @throws MarktmentorApiException
     */
    public function category(int $categoryId, ?array $options = null): ?CategoryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "api/public/v1/reference/categories/{$categoryId}/",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return CategoryResponse::fromJson($json);
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
     * Brand names that hold your search text, the brand with the most products first. The `brand` filter of a product search needs the exact name: copy it from this response.
     *
     * This request is free: it does not count as a research request.
     *
     * Example:
     * ```php
     * $client->reference->brands(
     *     new BrandsReferenceRequest([
     *         'search' => 'philips',
     *     ]),
     * );
     * ```
     *
     * @param BrandsReferenceRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?BrandListResponse
     * @throws MarktmentorException
     * @throws MarktmentorApiException
     */
    public function brands(BrandsReferenceRequest $request, ?array $options = null): ?BrandListResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        $query['search'] = $request->search;
        if ($request->limit != null) {
            $query['limit'] = $request->limit;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "api/public/v1/reference/brands/",
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
                return BrandListResponse::fromJson($json);
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
     * The bol category tree. Use it to find the `categoryId` for the product, niche and store filters. Send `level=1` for the top of the tree, `parentId` for the categories below one category, or `search` to find a category by name. Without a filter you get all categories, in the order of the tree.
     *
     * This request is free: it does not count as a research request.
     *
     * @param CategoriesReferenceRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?CategoryListResponse
     * @throws MarktmentorException
     * @throws MarktmentorApiException
     */
    private function _categories(CategoriesReferenceRequest $request = new CategoriesReferenceRequest(), ?array $options = null): ?CategoryListResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->level != null) {
            $query['level'] = $request->level;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->pageSize != null) {
            $query['pageSize'] = $request->pageSize;
        }
        if ($request->parentId != null) {
            $query['parentId'] = $request->parentId;
        }
        if ($request->search != null) {
            $query['search'] = $request->search;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "api/public/v1/reference/categories/",
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
                return CategoryListResponse::fromJson($json);
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
