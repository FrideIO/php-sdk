<?php

namespace Fride\Api;

use Fride\Client;
use Fride\Schemas\PayoffCreateRequest;
use Fride\Schemas\PayoffGetInfoRequest;

class Payoffs
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * POST payoff/create
     * @return array<string, mixed>
     */
    public function create(PayoffCreateRequest $request): array
    {
        $payload = $request->toArray();
        /** @var array<string, mixed> $res */
        $res = $this->client->post('payoff/create', $payload);
        return $res;
    }

    /**
     * GET payoff/getInfo
     * @return array<string, mixed>
     */
    public function getInfo(PayoffGetInfoRequest $request): array
    {
        $query = $request->toArray();
        /** @var array<string, mixed> $res */
        $res = $this->client->get('payoff/getInfo', $query);
        return $res;
    }

    /**
     * GET payoff/getRates
     * @return array<string, mixed>
     */
    public function getRates(): array
    {
        /** @var array<string, mixed> $res */
        $res = $this->client->get('payoff/getRates');
        return $res;
    }

    /**
     * GET payoff/getSbpBanks
     * @return array<string, mixed>
     */
    public function getSbpBanks(): array
    {
        /** @var array<string, mixed> $res */
        $res = $this->client->get('payoff/getSbpBanks');
        return $res;
    }
}


