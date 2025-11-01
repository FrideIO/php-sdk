<?php

namespace Fride\Exceptions;

use Exception;

class FrideApiException extends Exception
{
    private int $statusCode;
    /** @var array<string, mixed>|list<mixed>|null */
    private ?array $responseData;
    private ?string $responseBody;
    private ?string $url;
    private ?string $method;
    /** @var array<string, string>|null */
    private ?array $headers;
    /** @var array<string, mixed>|null */
    private ?array $requestBody;

    /**
     * @param array<string, mixed>|list<mixed>|null $responseData
     * @param array<string, string>|null $headers
     * @param array<string, mixed>|null $requestBody
     */
    public function __construct(
        string $message,
        int $statusCode,
        ?string $url = null,
        ?string $method = null,
        ?string $responseBody = null,
        ?array $responseData = null,
        ?array $headers = null,
        ?array $requestBody = null
    ) {
        parent::__construct($message, $statusCode);
        $this->statusCode = $statusCode;
        $this->url = $url;
        $this->method = $method;
        $this->responseBody = $responseBody;
        $this->responseData = $responseData;
        $this->headers = $headers;
        $this->requestBody = $requestBody;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /** @return array<string, mixed>|list<mixed>|null */
    public function getResponseData(): ?array
    {
        return $this->responseData;
    }

    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    /** @return array<string, string>|null */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    public function getHeader(string $name): ?string
    {
        if ($this->headers === null) {
            return null;
        }
        $key = strtolower($name);
        return $this->headers[$key] ?? null;
    }

    /** @return array<string, mixed>|null */
    public function getRequestBody(): ?array
    {
        return $this->requestBody;
    }
}


