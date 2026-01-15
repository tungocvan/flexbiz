<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\WpProduct;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;

class ProductDetail extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->product = WpProduct::with(['categories'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function increment()
    {
        $this->quantity++;
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $sessionId = Session::getId();
        $cart = Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => auth()->id()]
        );

        $price = $this->product->sale_price > 0 ? $this->product->sale_price : $this->product->regular_price;

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $this->product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $this->quantity;
            $cartItem->total = $cartItem->quantity * $price;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $this->product->id,
                'price' => $price,
                'quantity' => $this->quantity,
                'total' => $price * $this->quantity,
            ]);
        }

        $this->dispatch('cart-updated');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã thêm vào giỏ hàng!']);
    }

    public function render()
    {
        return view('Website::livewire.products.product-detail');
    }
}
