<?php

namespace MarktMentor\Niches;

use Psr\Http\Client\ClientInterface;
use MarktMentor\Core\Client\RawClient;
use MarktMentor\Niches\Requests\ListNichesRequest;
use MarktMentor\Core\Pagination\Pager;
use MarktMentor\Types\NicheItem;
use MarktMentor\Core\Pagination\OffsetPager;
use MarktMentor\Types\NicheListResponse;
use MarktMentor\Niches\Requests\GetNichesRequest;
use MarktMentor\Types\NicheDetailResponse;
use MarktMentor\Exceptions\MarktMentorException;
use MarktMentor\Exceptions\MarktMentorApiException;
use MarktMentor\Core\Json\JsonApiRequest;
use MarktMentor\Environments;
use MarktMentor\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use MarktMentor\Niches\Requests\ReviewHistoryNichesRequest;
use MarktMentor\Types\NicheHistoryResponse;
use MarktMentor\Types\ReviewSummaryResponse;
use MarktMentor\Niches\Requests\ProductDistributionsNichesRequest;
use MarktMentor\Types\NicheDistributionsResponse;
use MarktMentor\Niches\Requests\ProductsNichesRequest;
use MarktMentor\Types\ProductItem;
use MarktMentor\Types\ProductListResponse;
use MarktMentor\Niches\Requests\ReviewsNichesRequest;
use MarktMentor\Types\ReviewItem;
use MarktMentor\Types\ReviewListResponse;

class NichesClient
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
     * Search niches by text or category. A niche is a group of products that serve the same customer need. Each result has the metrics per market for the chosen period.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->niches->list(
     *     new ListNichesRequest([
     *         'search' => 'drinkfles',
     *     ]),
     * );
     * ```
     *
     * @param ListNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<NicheItem>
     */
    public function list(ListNichesRequest $request = new ListNichesRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (ListNichesRequest $request) => $this->_list($request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (ListNichesRequest $request) => $request?->page ?? 0,
            setOffset: function (ListNichesRequest $request, int $offset) {
                $request->page = $offset;
            },
            getStep: null,
            /* @phpstan-ignore-next-line */
            getItems: fn (?NicheListResponse $response) => $response?->data ?? [],
            /* @phpstan-ignore-next-line */
            hasNextPage: fn (?NicheListResponse $response) => $response?->pagination?->hasNext,
        );
    }

    /**
     * Get one niche with its quality score, competition score and the metrics per market for the chosen period. With comparePeriods the response also has the core metrics for 30, 90 and 365 days.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->niches->get(
     *     1,
     *     new GetNichesRequest([]),
     * );
     * ```
     *
     * @param int $nicheId Niche identifier returned as nicheId by Search niches.
     * @param GetNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?NicheDetailResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function get(int $nicheId, GetNichesRequest $request = new GetNichesRequest(), ?array $options = null): ?NicheDetailResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->comparePeriods != null) {
            $query['comparePeriods'] = $request->comparePeriods;
        }
        if ($request->market != null) {
            $query['market'] = $request->market;
        }
        if ($request->period != null) {
            $query['period'] = $request->period;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/niches/{$nicheId}/",
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
                return NicheDetailResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktMentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktMentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktMentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Get the number of reviews and the average rating of the products in a niche over time.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->niches->reviewHistory(
     *     1,
     *     new ReviewHistoryNichesRequest([]),
     * );
     * ```
     *
     * @param int $nicheId Niche identifier returned as nicheId by Search niches.
     * @param ReviewHistoryNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?NicheHistoryResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function reviewHistory(int $nicheId, ReviewHistoryNichesRequest $request = new ReviewHistoryNichesRequest(), ?array $options = null): ?NicheHistoryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->interval != null) {
            $query['interval'] = $request->interval;
        }
        if ($request->market != null) {
            $query['market'] = $request->market;
        }
        if ($request->period != null) {
            $query['period'] = $request->period;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/niches/{$nicheId}/review-history/",
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
                return NicheHistoryResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktMentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktMentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktMentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Get the review totals of the products in a niche: the number of reviews, the average rating, the count per star rating and the most named positive and negative topics.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->niches->reviewSummary(
     *     1,
     * );
     * ```
     *
     * @param int $nicheId Niche identifier returned as nicheId by Search niches.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ReviewSummaryResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function reviewSummary(int $nicheId, ?array $options = null): ?ReviewSummaryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/niches/{$nicheId}/reviews/summary/",
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
                return ReviewSummaryResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktMentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktMentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktMentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Get how the products of a niche are spread over price, sales and revenue, for both markets together.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->niches->productDistributions(
     *     1,
     *     new ProductDistributionsNichesRequest([]),
     * );
     * ```
     *
     * @param int $nicheId Niche identifier returned as nicheId by Search niches.
     * @param ProductDistributionsNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?NicheDistributionsResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function productDistributions(int $nicheId, ProductDistributionsNichesRequest $request = new ProductDistributionsNichesRequest(), ?array $options = null): ?NicheDistributionsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->period != null) {
            $query['period'] = $request->period;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/niches/{$nicheId}/product-distributions/",
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
                return NicheDistributionsResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktMentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktMentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktMentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * List the products in a niche, with the same filters and the same product data as Search products.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->niches->products(
     *     1,
     *     new ProductsNichesRequest([
     *         'brand' => 'Kambukka',
     *         'ean' => '5407005143414',
     *         'search' => 'drinkfles',
     *     ]),
     * );
     * ```
     *
     * @param int $nicheId Niche identifier returned as nicheId by Search niches.
     * @param ProductsNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<ProductItem>
     */
    public function products(int $nicheId, ProductsNichesRequest $request = new ProductsNichesRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (ProductsNichesRequest $request) => $this->_products($nicheId, $request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (ProductsNichesRequest $request) => $request?->page ?? 0,
            setOffset: function (ProductsNichesRequest $request, int $offset) {
                $request->page = $offset;
            },
            getStep: null,
            /* @phpstan-ignore-next-line */
            getItems: fn (?ProductListResponse $response) => $response?->data ?? [],
            /* @phpstan-ignore-next-line */
            hasNextPage: fn (?ProductListResponse $response) => $response?->pagination?->hasNext,
        );
    }

    /**
     * List the reviews of the products in a niche. Filter on score, verified purchase and text.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->niches->reviews(
     *     1,
     *     new ReviewsNichesRequest([
     *         'search' => 'drinkfles',
     *     ]),
     * );
     * ```
     *
     * @param int $nicheId Niche identifier returned as nicheId by Search niches.
     * @param ReviewsNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<ReviewItem>
     */
    public function reviews(int $nicheId, ReviewsNichesRequest $request = new ReviewsNichesRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (ReviewsNichesRequest $request) => $this->_reviews($nicheId, $request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (ReviewsNichesRequest $request) => $request?->page ?? 0,
            setOffset: function (ReviewsNichesRequest $request, int $offset) {
                $request->page = $offset;
            },
            getStep: null,
            /* @phpstan-ignore-next-line */
            getItems: fn (?ReviewListResponse $response) => $response?->data ?? [],
            /* @phpstan-ignore-next-line */
            hasNextPage: fn (?ReviewListResponse $response) => $response?->pagination?->hasNext,
        );
    }

    /**
     * Search niches by text or category. A niche is a group of products that serve the same customer need. Each result has the metrics per market for the chosen period.
     *
     * A successful request counts as one research request.
     *
     * @param ListNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?NicheListResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    private function _list(ListNichesRequest $request = new ListNichesRequest(), ?array $options = null): ?NicheListResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->categoryId != null) {
            $query['categoryId'] = $request->categoryId;
        }
        if ($request->market != null) {
            $query['market'] = $request->market;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->pageSize != null) {
            $query['pageSize'] = $request->pageSize;
        }
        if ($request->period != null) {
            $query['period'] = $request->period;
        }
        if ($request->search != null) {
            $query['search'] = $request->search;
        }
        if ($request->sort != null) {
            $query['sort'] = $request->sort;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/niches/",
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
                return NicheListResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktMentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktMentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktMentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * List the products in a niche, with the same filters and the same product data as Search products.
     *
     * A successful request counts as one research request.
     *
     * @param int $nicheId Niche identifier returned as nicheId by Search niches.
     * @param ProductsNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ProductListResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    private function _products(int $nicheId, ProductsNichesRequest $request = new ProductsNichesRequest(), ?array $options = null): ?ProductListResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->brand != null) {
            $query['brand'] = $request->brand;
        }
        if ($request->categoryId != null) {
            $query['categoryId'] = $request->categoryId;
        }
        if ($request->ean != null) {
            $query['ean'] = $request->ean;
        }
        if ($request->market != null) {
            $query['market'] = $request->market;
        }
        if ($request->maxPrice != null) {
            $query['maxPrice'] = $request->maxPrice;
        }
        if ($request->maxRating != null) {
            $query['maxRating'] = $request->maxRating;
        }
        if ($request->maxRevenue != null) {
            $query['maxRevenue'] = $request->maxRevenue;
        }
        if ($request->maxSales != null) {
            $query['maxSales'] = $request->maxSales;
        }
        if ($request->minPrice != null) {
            $query['minPrice'] = $request->minPrice;
        }
        if ($request->minRating != null) {
            $query['minRating'] = $request->minRating;
        }
        if ($request->minRevenue != null) {
            $query['minRevenue'] = $request->minRevenue;
        }
        if ($request->minSales != null) {
            $query['minSales'] = $request->minSales;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->pageSize != null) {
            $query['pageSize'] = $request->pageSize;
        }
        if ($request->period != null) {
            $query['period'] = $request->period;
        }
        if ($request->search != null) {
            $query['search'] = $request->search;
        }
        if ($request->sort != null) {
            $query['sort'] = $request->sort;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/niches/{$nicheId}/products/",
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
                return ProductListResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktMentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktMentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktMentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * List the reviews of the products in a niche. Filter on score, verified purchase and text.
     *
     * A successful request counts as one research request.
     *
     * @param int $nicheId Niche identifier returned as nicheId by Search niches.
     * @param ReviewsNichesRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ReviewListResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    private function _reviews(int $nicheId, ReviewsNichesRequest $request = new ReviewsNichesRequest(), ?array $options = null): ?ReviewListResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->market != null) {
            $query['market'] = $request->market;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->pageSize != null) {
            $query['pageSize'] = $request->pageSize;
        }
        if ($request->period != null) {
            $query['period'] = $request->period;
        }
        if ($request->score != null) {
            $query['score'] = $request->score;
        }
        if ($request->search != null) {
            $query['search'] = $request->search;
        }
        if ($request->sort != null) {
            $query['sort'] = $request->sort;
        }
        if ($request->verified != null) {
            $query['verified'] = $request->verified;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/niches/{$nicheId}/reviews/",
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
                return ReviewListResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new MarktMentorException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new MarktMentorException(message: $e->getMessage(), previous: $e);
        }
        throw new MarktMentorApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }
}
