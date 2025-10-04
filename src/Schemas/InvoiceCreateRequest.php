<?php

namespace Fride\Schemas;

class InvoiceCreateRequest
{
    public string $merchant_id;
    public string $order_id;
    public float $amount;
    public string $currency; // RUB, UAH, USD, EUR
    public ?string $comment = null;
    public ?int $expire = null;
    /** @var array<string, string>|null */
    public ?array $custom_fields = null;

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $req = new self();
        $req->merchant_id = (string)$data['merchant_id'];
        $req->order_id = (string)$data['order_id'];
        $req->amount = (float)$data['amount'];
        $req->currency = (string)$data['currency'];
        $req->comment = isset($data['comment']) ? (string)$data['comment'] : null;
        $req->expire = isset($data['expire']) ? (int)$data['expire'] : null;
        $req->custom_fields = isset($data['custom_fields']) ? (array)$data['custom_fields'] : null;
        return $req;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $out = [
            'merchant_id' => $this->merchant_id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
        if ($this->comment !== null) {
            $out['comment'] = $this->comment;
        }
        if ($this->expire !== null) {
            $out['expire'] = $this->expire;
        }
        if ($this->custom_fields !== null) {
            $out['custom_fields'] = $this->custom_fields;
        }
        return $out;
    }
}


