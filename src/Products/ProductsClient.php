<?php

namespace MarktMentor\Products;

use Psr\Http\Client\ClientInterface;
use MarktMentor\Core\Client\RawClient;
use MarktMentor\Products\Requests\ListProductsRequest;
use MarktMentor\Core\Pagination\Pager;
use MarktMentor\Types\ProductItem;
use MarktMentor\Core\Pagination\OffsetPager;
use MarktMentor\Types\ProductListResponse;
use MarktMentor\Products\Requests\GetProductsRequest;
use MarktMentor\Types\ProductDetailResponse;
use MarktMentor\Exceptions\MarktMentorException;
use MarktMentor\Exceptions\MarktMentorApiException;
use MarktMentor\Core\Json\JsonApiRequest;
use MarktMentor\Environments;
use MarktMentor\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use MarktMentor\Products\Requests\SalesHistoryProductsRequest;
use MarktMentor\Types\SalesHistoryResponse;
use MarktMentor\Products\Requests\VisibilityHistoryProductsRequest;
use MarktMentor\Types\VisibilityHistoryResponse;
use MarktMentor\Products\Requests\CategoryRankingsProductsRequest;
use MarktMentor\Types\CategoryRankingsResponse;
use MarktMentor\Products\Requests\KeywordRankingsProductsRequest;
use MarktMentor\Types\KeywordRankingsResponse;
use MarktMentor\Products\Requests\KeywordsProductsRequest;
use MarktMentor\Types\KeywordItem;
use MarktMentor\Types\KeywordResponse;
use MarktMentor\Products\Requests\SellersProductsRequest;
use MarktMentor\Types\SellerResponse;
use MarktMentor\Products\Requests\ReviewsProductsRequest;
use MarktMentor\Types\ReviewItem;
use MarktMentor\Types\ReviewListResponse;
use MarktMentor\Products\Requests\ReviewSummaryProductsRequest;
use MarktMentor\Types\ReviewSummaryResponse;

class ProductsClient
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
     * Search bol products by text, EAN, brand or category, with filters on sales, revenue, price and rating. Each result has the product data and the metrics per market for the chosen period.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->list(
     *     new ListProductsRequest([
     *         'brand' => 'Kambukka',
     *         'ean' => '5407005143414',
     *         'search' => 'drinkfles',
     *     ]),
     * );
     * ```
     *
     * @param ListProductsRequest $request
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
    public function list(ListProductsRequest $request = new ListProductsRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (ListProductsRequest $request) => $this->_list($request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (ListProductsRequest $request) => $request?->page ?? 0,
            setOffset: function (ListProductsRequest $request, int $offset) {
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
     * Get one product by its bol product code, with the metrics per market for the chosen period, its dimensions, commission and the codes of its variants.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->get(
     *     '9300000138905032',
     *     new GetProductsRequest([]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param GetProductsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ProductDetailResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function get(string $productCode, GetProductsRequest $request = new GetProductsRequest(), ?array $options = null): ?ProductDetailResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
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
                    path: "api/public/v1/research/products/{$productCode}/",
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
                return ProductDetailResponse::fromJson($json);
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
     * Get the sales figures of a product over time, per market, in calendar buckets of the chosen interval.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->salesHistory(
     *     '9300000138905032',
     *     new SalesHistoryProductsRequest([]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param SalesHistoryProductsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?SalesHistoryResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function salesHistory(string $productCode, SalesHistoryProductsRequest $request = new SalesHistoryProductsRequest(), ?array $options = null): ?SalesHistoryResponse
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
                    path: "api/public/v1/research/products/{$productCode}/sales-history/",
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
                return SalesHistoryResponse::fromJson($json);
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
     * Get the search visibility of a product over time, per market, in calendar buckets of the chosen interval.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->visibilityHistory(
     *     '9300000138905032',
     *     new VisibilityHistoryProductsRequest([]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param VisibilityHistoryProductsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?VisibilityHistoryResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function visibilityHistory(string $productCode, VisibilityHistoryProductsRequest $request = new VisibilityHistoryProductsRequest(), ?array $options = null): ?VisibilityHistoryResponse
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
                    path: "api/public/v1/research/products/{$productCode}/visibility-history/",
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
                return VisibilityHistoryResponse::fromJson($json);
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
     * Get the positions of a product in its bol categories over time.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->categoryRankings(
     *     '9300000138905032',
     *     new CategoryRankingsProductsRequest([]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param CategoryRankingsProductsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?CategoryRankingsResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function categoryRankings(string $productCode, CategoryRankingsProductsRequest $request = new CategoryRankingsProductsRequest(), ?array $options = null): ?CategoryRankingsResponse
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
                    path: "api/public/v1/research/products/{$productCode}/category-rankings/",
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
                return CategoryRankingsResponse::fromJson($json);
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
     * Get the positions of a product in the bol search results over time, per keyword and market. Name up to 25 keywords with keywordIds (the keywordId values of the keywords endpoint), or get the 10 keywords with the highest search volume.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->keywordRankings(
     *     '9300000138905032',
     *     new KeywordRankingsProductsRequest([
     *         'keywordIds' => '6797,6800,5150',
     *     ]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param KeywordRankingsProductsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?KeywordRankingsResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function keywordRankings(string $productCode, KeywordRankingsProductsRequest $request = new KeywordRankingsProductsRequest(), ?array $options = null): ?KeywordRankingsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->interval != null) {
            $query['interval'] = $request->interval;
        }
        if ($request->keywordIds != null) {
            $query['keywordIds'] = $request->keywordIds;
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
                    path: "api/public/v1/research/products/{$productCode}/keyword-rankings/",
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
                return KeywordRankingsResponse::fromJson($json);
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
     * List the search terms a product ranked for in the period, with the figures per market.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->keywords(
     *     '9300000138905032',
     *     new KeywordsProductsRequest([]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param KeywordsProductsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<KeywordItem>
     */
    public function keywords(string $productCode, KeywordsProductsRequest $request = new KeywordsProductsRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (KeywordsProductsRequest $request) => $this->_keywords($productCode, $request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (KeywordsProductsRequest $request) => $request?->page ?? 0,
            setOffset: function (KeywordsProductsRequest $request, int $offset) {
                $request->page = $offset;
            },
            getStep: null,
            /* @phpstan-ignore-next-line */
            getItems: fn (?KeywordResponse $response) => $response?->data ?? [],
            /* @phpstan-ignore-next-line */
            hasNextPage: fn (?KeywordResponse $response) => $response?->pagination?->hasNext,
        );
    }

    /**
     * List the sellers that offered a product in the period, with the figures per market, a buy box summary and the changes to the listing.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->sellers(
     *     '9300000138905032',
     *     new SellersProductsRequest([]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param SellersProductsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?SellerResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    public function sellers(string $productCode, SellersProductsRequest $request = new SellersProductsRequest(), ?array $options = null): ?SellerResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
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
                    path: "api/public/v1/research/products/{$productCode}/sellers/",
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
                return SellerResponse::fromJson($json);
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
     * List the reviews of a product, with rating, text and date. Filter on score, verified purchase and text. By default the list has the reviews of the whole product family, as bol shows them on the product page; includeVariants=false gives only the reviews written for this product.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->reviews(
     *     '9300000138905032',
     *     new ReviewsProductsRequest([
     *         'search' => 'drinkfles',
     *     ]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param ReviewsProductsRequest $request
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
    public function reviews(string $productCode, ReviewsProductsRequest $request = new ReviewsProductsRequest(), ?array $options = null): Pager
    {
        return new OffsetPager(
            request: $request,
            getNextPage: fn (ReviewsProductsRequest $request) => $this->_reviews($productCode, $request, $options),
            /* @phpstan-ignore-next-line */
            getOffset: fn (ReviewsProductsRequest $request) => $request?->page ?? 0,
            setOffset: function (ReviewsProductsRequest $request, int $offset) {
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
     * Get the review totals of a product: the number of reviews, the average rating, the count per star rating and the most named positive and negative topics. By default over the whole product family; includeVariants=false gives only the reviews written for this product.
     *
     * A successful request counts as one research request.
     *
     * Example:
     * ```php
     * $client->products->reviewSummary(
     *     '9300000138905032',
     *     new ReviewSummaryProductsRequest([]),
     * );
     * ```
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param ReviewSummaryProductsRequest $request
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
    public function reviewSummary(string $productCode, ReviewSummaryProductsRequest $request = new ReviewSummaryProductsRequest(), ?array $options = null): ?ReviewSummaryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->includeVariants != null) {
            $query['includeVariants'] = $request->includeVariants;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/products/{$productCode}/reviews/summary/",
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
     * Search bol products by text, EAN, brand or category, with filters on sales, revenue, price and rating. Each result has the product data and the metrics per market for the chosen period.
     *
     * A successful request counts as one research request.
     *
     * @param ListProductsRequest $request
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
    private function _list(ListProductsRequest $request = new ListProductsRequest(), ?array $options = null): ?ProductListResponse
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
        if ($request->variantsOf != null) {
            $query['variantsOf'] = $request->variantsOf;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/products/",
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
     * List the search terms a product ranked for in the period, with the figures per market.
     *
     * A successful request counts as one research request.
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param KeywordsProductsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?KeywordResponse
     * @throws MarktMentorException
     * @throws MarktMentorApiException
     */
    private function _keywords(string $productCode, KeywordsProductsRequest $request = new KeywordsProductsRequest(), ?array $options = null): ?KeywordResponse
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
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Production->value,
                    path: "api/public/v1/research/products/{$productCode}/keywords/",
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
                return KeywordResponse::fromJson($json);
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
     * List the reviews of a product, with rating, text and date. Filter on score, verified purchase and text. By default the list has the reviews of the whole product family, as bol shows them on the product page; includeVariants=false gives only the reviews written for this product.
     *
     * A successful request counts as one research request.
     *
     * @param string $productCode Bol product identifier, returned as productCode. Or `ean:` with a 13-digit EAN, for example `ean:8712345678901`: the API then uses the product with that EAN. When more than one product has the EAN, the request gets HTTP 409 with the candidate product codes.
     * @param ReviewsProductsRequest $request
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
    private function _reviews(string $productCode, ReviewsProductsRequest $request = new ReviewsProductsRequest(), ?array $options = null): ?ReviewListResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->includeVariants != null) {
            $query['includeVariants'] = $request->includeVariants;
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
                    path: "api/public/v1/research/products/{$productCode}/reviews/",
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
