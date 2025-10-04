<?php

namespace Fride\Exceptions;

use Exception;

class FrideHttpException extends Exception
{
    private ?int $curlCode = null;
    private ?string $url = null;
    private ?string $method = null;

    public static function withContext(string $message, ?int $curlCode = null, ?string $url = null, ?string $method = null): self
    {
        $e = new self($message);
        $e->curlCode = $curlCode;
        $e->url = $url;
        $e->method = $method;
        return $e;
    }

    public function getCurlCode(): ?int
    {
        return $this->curlCode;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }
}


