<?php

namespace Fride\Api;

use Fride\Client;

class Accounts
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * GET user/getBalance
     * @return array<string, mixed>
     */
    public function getBalance(): array
    {
        /** @var array<string, mixed> $res */
        $res = $this->client->get('user/getBalance');
        return $res;
    }
}


