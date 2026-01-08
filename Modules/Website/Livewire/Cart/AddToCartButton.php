<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Modules\Website\Livewire\Concerns\InteractsWithCart;

class AddToCartButton extends Component
{
    use InteractsWithCart;

    public int $productId;
    public string $name;
    public int $price;
    public ?string $image = null;

    public function addToCart(): void
    {
        $cart = $this->getCart();

        if (isset($cart[$this->productId])) {
            $cart[$this->productId]['qty']++;
        } else {
            $cart[$this->productId] = [
                'id'    => $this->productId,
                'name'  => $this->name,
                'price' => $this->price,
                'qty'   => 1,
                'image' => $this->image,
            ];
        }

        $this->putCart($cart);

        // Livewire 3 chuẩn
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('Website::livewire.cart.add-to-cart-button');
    }
}
