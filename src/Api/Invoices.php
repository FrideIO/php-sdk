<?php

namespace Fride\Api;

use Fride\Client;
use Fride\Schemas\InvoiceCreateRequest;
use Fride\Schemas\InvoiceGetInfoRequest;

class Invoices
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * POST invoices/create
     * @return array<string, mixed>
     */
    public function create(InvoiceCreateRequest $request): array
    {
        $payload = $request->toArray();
        /** @var array<string, mixed> $res */
        $res = $this->client->post('invoices/create', $payload);
        return $res;
    }

    /**
     * GET invoice/getInfo
     * @return array<string, mixed>
     */
    public function getInfo(InvoiceGetInfoRequest $request): array
    {
        $query = $request->toArray();
        /** @var array<string, mixed> $res */
        $res = $this->client->get('invoice/getInfo', $query);
        return $res;
    }
}


