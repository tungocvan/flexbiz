<?php

namespace Modules\Website\Services\Cart;

class CartItem
{
    public int $productId;
    public string $title;
    public float $price;
    public ?float $salePrice;
    public int $qty;
    public ?string $image;

    public function __construct(
        int $productId,
        string $title,
        float $price,
        ?float $salePrice,
        int $qty = 1,
        ?string $image = null
    ) {
        $this->productId = $productId;
        $this->title     = $title;
        $this->price     = $price;
        $this->salePrice = $salePrice;
        $this->qty       = $qty;
        $this->image     = $image;
    }

    public function unitPrice(): float
    {
        return $this->salePrice ?? $this->price;
    }

    public function subtotal(): float
    {
        return $this->unitPrice() * $this->qty;
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'title'      => $this->title,
            'price'      => $this->price,
            'sale_price' => $this->salePrice,
            'qty'        => $this->qty,
            'image'      => $this->image,
        ];
    }
}
