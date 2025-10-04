<?php

namespace Fride\Schemas;

class InvoiceGetInfoRequest
{
    public string $merchant_id;
    public ?string $invoice_id = null; // uuid
    public ?string $order_id = null;   // merchant order id

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $req = new self();
        $req->merchant_id = (string)$data['merchant_id'];
        $req->invoice_id = isset($data['invoice_id']) ? (string)$data['invoice_id'] : null;
        $req->order_id = isset($data['order_id']) ? (string)$data['order_id'] : null;
        return $req;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $out = [
            'merchant_id' => $this->merchant_id,
        ];
        if ($this->invoice_id !== null) {
            $out['invoice_id'] = $this->invoice_id;
        }
        if ($this->order_id !== null) {
            $out['order_id'] = $this->order_id;
        }
        return $out;
    }
}


