<?php

namespace Fride\Schemas;

class ShopGetServicesRequest
{
    public string $shop_id;

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $req = new self();
        $req->shop_id = (string)$data['shop_id'];
        return $req;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'shop_id' => $this->shop_id,
        ];
    }
}


