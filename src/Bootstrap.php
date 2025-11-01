<?php

namespace Fride;

use Fride\Api\Accounts;
use Fride\Api\Invoices;
use Fride\Api\Payoffs;
use Fride\Api\Services;

class Bootstrap
{
    private Client $client;
    private Invoices $invoices;
    private Payoffs $payoffs;
    private Accounts $accounts;
    private Services $services;

    public function __construct(string $apiKey, string $baseUrl, int $timeoutSeconds = 30, int $connectTimeoutSeconds = 10)
    {
        $this->client = new Client($apiKey, $baseUrl, $timeoutSeconds, $connectTimeoutSeconds);
        $this->invoices = new Invoices($this->client);
        $this->payoffs = new Payoffs($this->client);
        $this->accounts = new Accounts($this->client);
        $this->services = new Services($this->client);
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function invoices(): Invoices
    {
        return $this->invoices;
    }

    public function payoffs(): Payoffs
    {
        return $this->payoffs;
    }

    public function accounts(): Accounts
    {
        return $this->accounts;
    }

    public function services(): Services
    {
        return $this->services;
    }
}


