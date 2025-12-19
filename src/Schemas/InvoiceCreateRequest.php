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
	public ?string $service = null;
	public ?string $email = null;
	public ?string $success_url = null;
	public ?string $fail_url = null;

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
		$req->service = isset($data['service']) ? (string)$data['service'] : null;
		$req->email = isset($data['email']) ? (string)$data['email'] : null;
		$req->success_url = isset($data['success_url']) ? (string)$data['success_url'] : null;
		$req->fail_url = isset($data['fail_url']) ? (string)$data['fail_url'] : null;
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
        if ($this->service !== null) {
            $out['service'] = $this->service;
        }
        if ($this->email !== null) {
            $out['email'] = $this->email;
        }
        if ($this->success_url !== null) {
            $out['success_url'] = $this->success_url;
        }
        if ($this->fail_url !== null) {
            $out['fail_url'] = $this->fail_url;
        }
        return $out;
    }
}


