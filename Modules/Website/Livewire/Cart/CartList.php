<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;

class CartList extends Component
{
    // Ngưỡng Freeship (Ví dụ 1 triệu)
    public $freeShippingThreshold = 1000000;

    #[Computed]
    public function cartData()
    {
        $sessionId = Session::getId();
        $cart = Cart::with(['items.product'])
            ->where('session_id', $sessionId)
            ->first();

        return [
            'cart' => $cart,
            'items' => $cart ? $cart->items : collect([]),
            'subtotal' => $cart ? $cart->items->sum('total') : 0,
        ];
    }

    public function increment($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $item->increment('quantity');
            $this->recalculateItem($item);
        }
    }

    public function decrement($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item && $item->quantity > 1) {
            $item->decrement('quantity');
            $this->recalculateItem($item);
        }
    }

    public function remove($itemId)
    {
        CartItem::destroy($itemId);
        $this->dispatch('cart-updated');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
    }

    private function recalculateItem($item)
    {
        // Tính lại giá total của item
        $item->total = $item->quantity * $item->price;
        $item->save();
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('Website::livewire.cart.cart-list');
    }
}