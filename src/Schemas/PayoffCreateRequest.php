<?php

namespace Fride\Schemas;

class PayoffCreateRequest
{
    public string $service;
    public string $wallet_to;
    public float $amount;
    public int $subtract = 2; // 1 - balance, 2 - amount
    public ?string $order_id = null;
    public ?string $webhook_url = null;
    /** @var array<string, mixed>|null */
    public ?array $payoff_data = null;

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $req = new self();
        $req->service = (string)$data['service'];
        $req->wallet_to = (string)$data['wallet_to'];
        $req->amount = (float)$data['amount'];
        if (isset($data['subtract'])) {
            $req->subtract = (int)$data['subtract'];
        }
        $req->order_id = isset($data['order_id']) ? (string)$data['order_id'] : null;
        $req->webhook_url = isset($data['webhook_url']) ? (string)$data['webhook_url'] : null;
        $req->payoff_data = isset($data['payoff_data']) ? (array)$data['payoff_data'] : null;
        return $req;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $out = [
            'service' => $this->service,
            'wallet_to' => $this->wallet_to,
            'amount' => $this->amount,
            'subtract' => $this->subtract,
        ];
        if ($this->order_id !== null) {
            $out['order_id'] = $this->order_id;
        }
        if ($this->webhook_url !== null) {
            $out['webhook_url'] = $this->webhook_url;
        }
        if ($this->payoff_data !== null) {
            $out['payoff_data'] = $this->payoff_data;
        }
        return $out;
    }
}


