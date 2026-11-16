<?php

namespace MarktMentor\Usage;

use Psr\Http\Client\ClientInterface;
use MarktMentor\Core\Client\RawClient;
use MarktMentor\Types\Usage;
use MarktMentor\Exceptions\MarktmentorException;
use MarktMentor\Exceptions\MarktmentorApiException;
use MarktMentor\Core\Json\JsonApiRequest;
use MarktMentor\Environments;
use MarktMentor\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;

class UsageClient
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
     * Get the research requests of the organization in the current period: what the API bundle includes, what is used and what is left, or the state of the free monthly allowance. Use it to stop before the limit.
     *
     * This request is free: it does not count as a research request.
     *
     * Example:
     * ```php
     * $client->usage->get();
     * ```
     *
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Usage
     * @throws MarktmentorException
     * @throws MarktmentorApiException
     */
    public function get(?array $options = null): ?Usage
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "api/public/v1/usage/",
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
                return Usage::fromJson($json);
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
