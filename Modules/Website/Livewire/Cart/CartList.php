<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;

class CartList extends Component
{
    public function increment($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $item->quantity++;
            $item->total = $item->quantity * $item->price;
            $item->save();
            $this->dispatch('cart-updated');
        }
    }

    public function decrement($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item && $item->quantity > 1) {
            $item->quantity--;
            $item->total = $item->quantity * $item->price;
            $item->save();
            $this->dispatch('cart-updated');
        }
    }

    public function remove($itemId)
    {
        CartItem::destroy($itemId);
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        $sessionId = Session::getId();
        $cart = Cart::with(['items.product'])->where('session_id', $sessionId)->first();

        return view('Website::livewire.cart.cart-list', [
            'cart' => $cart,
            'items' => $cart ? $cart->items : collect([]),
            'total' => $cart ? $cart->items->sum('total') : 0
        ]);
    }
}
