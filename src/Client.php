<?php

namespace Fride;

use Fride\Exceptions\FrideApiException;
use Fride\Exceptions\FrideHttpException;

class Client
{
    private string $apiKey;
    private string $baseUrl;
    private int $timeoutSeconds;
    private int $connectTimeoutSeconds;

    public function __construct(string $apiKey, string $baseUrl, int $timeoutSeconds = 30, int $connectTimeoutSeconds = 10)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->timeoutSeconds = $timeoutSeconds;
        $this->connectTimeoutSeconds = $connectTimeoutSeconds;
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>|list<mixed>
     * @throws FrideHttpException
     * @throws FrideApiException
     */
    public function get(string $path, array $query = [])
    {
        $url = $this->buildUrl($path, $query);
        return $this->request('GET', $url, null);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>|list<mixed>
     * @throws FrideHttpException
     * @throws FrideApiException
     */
    public function post(string $path, array $body = [])
    {
        $url = $this->buildUrl($path);
        return $this->request('POST', $url, $body);
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>|list<mixed>
     * @throws FrideHttpException
     * @throws FrideApiException
     */
    private function request(string $method, string $url, ?array $body)
    {
        $ch = curl_init();
		
        if ($ch === false) {
            throw FrideHttpException::withContext('cURL initialization failed');
        }

        $headers = [
            'Accept: application/json',
            'X-Api-Key: ' . $this->apiKey,
        ];

        if ($method === 'POST') {
            $headers[] = 'Content-Type: application/json';
			
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeoutSeconds);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeoutSeconds);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        if ($response === false) {
            $err = curl_error($ch);
            $errno = curl_errno($ch);
			
            curl_close($ch);
			
            throw FrideHttpException::withContext(
                'Network error: ' . ($err !== '' ? $err : 'unknown'),
                $errno,
                $url,
                $method
            );
        }

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        $rawHeaders = substr($response, 0, $headerSize);
        $rawBody = substr($response, (int)$headerSize);

        $decoded = json_decode($rawBody, true);

        if ($status !== 200) {
            $errorMessage = null;
			
            if (is_array($decoded) && array_key_exists('error', $decoded) && is_string($decoded['error'])) {
                $errorMessage = $decoded['error'];
            }
			
            if ($errorMessage === null) {
                $errorMessage = 'Неизвестная ошибка';
            }
			
            throw new FrideApiException(
                $errorMessage,
                $status,
                $url,
                $method,
                is_string($rawBody) ? $rawBody : null,
                is_array($decoded) ? $decoded : null,
                self::parseHeaders($rawHeaders),
                $body
            );
        }

        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new FrideApiException(
                'Invalid JSON response',
                $status,
                $url,
                $method,
                is_string($rawBody) ? $rawBody : null,
                null,
                self::parseHeaders($rawHeaders),
                $body
            );
        }

        return $decoded;
    }

    /**
     * @param array<string, mixed> $query
     */
    private function buildUrl(string $path, array $query = []): string
    {
        $url = $this->baseUrl . '/' . ltrim($path, '/');
        if ($query !== []) {
            $url .= '?' . http_build_query($query);
        }
        return $url;
    }

    /**
     * @return array<string, string>
     */
    private static function parseHeaders(string $rawHeaders): array
    {
        $headers = [];
        foreach (preg_split("/(\r\n|\n|\r)/", $rawHeaders) as $line) {
            if (strpos($line, ':') !== false) {
                [$name, $value] = explode(':', $line, 2);
                $headers[strtolower(trim($name))] = trim($value);
            }
        }
        return $headers;
    }
}


