<?php

namespace Fride\Api;

use Fride\Client;
use Fride\Schemas\MerchantGetServicesRequest;

class Services
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * GET merchant/getServices
     * @return array<string, mixed>
     */
    public function getMerchantServices(MerchantGetServicesRequest $request): array
    {
        $query = $request->toArray();
        /** @var array<string, mixed> $res */
        $res = $this->client->get('merchant/getServices', $query);
        return $res;
    }

    /**
     * GET payoff/getServices
     * @return array<string, mixed>
     */
    public function getPayoffServices(): array
    {
        /** @var array<string, mixed> $res */
        $res = $this->client->get('payoff/getServices');
        return $res;
    }
}


