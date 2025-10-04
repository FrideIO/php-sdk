<?php

namespace Fride\Schemas;

class PayoffGetInfoRequest
{
    public ?string $payoff_id = null; // uuid
    public ?string $order_id = null;

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $req = new self();
        $req->payoff_id = isset($data['payoff_id']) ? (string)$data['payoff_id'] : null;
        $req->order_id = isset($data['order_id']) ? (string)$data['order_id'] : null;
        return $req;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $out = [];
        if ($this->payoff_id !== null) {
            $out['payoff_id'] = $this->payoff_id;
        }
        if ($this->order_id !== null) {
            $out['order_id'] = $this->order_id;
        }
        return $out;
    }
}


