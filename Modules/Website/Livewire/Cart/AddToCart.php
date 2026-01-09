<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;
use Modules\Website\Models\WpProduct;

class AddToCart extends Component
{
    public int $productId;
    public int $quantity = 1;

    public function add()
    {
        $product = WpProduct::where('is_active', true)
            ->findOrFail($this->productId);

        $sessionId = session()->getId();

        $cart = Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => auth()->id()]
        );

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        $price = $product->final_price;

        if ($item) {
            $item->quantity += $this->quantity;
            $item->total = $item->quantity * $price;
            $item->save();
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'price'      => $price,
                'quantity'   => $this->quantity,
                'total'      => $price * $this->quantity,
            ]);
        }

        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('Website::livewire.cart.add-to-cart');
    }
}
