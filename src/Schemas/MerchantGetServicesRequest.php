<?php

namespace Fride\Schemas;

class MerchantGetServicesRequest
{
    public string $merchant_id;

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $req = new self();
        $req->merchant_id = (string)$data['merchant_id'];
        return $req;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'merchant_id' => $this->merchant_id,
        ];
    }
}


