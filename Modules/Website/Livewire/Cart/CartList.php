<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;

class CartList extends Component
{
    public $cart;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = Cart::with('items.product')
            ->where('session_id', session()->getId())
            ->first();
    }

    public function updateQuantity(int $itemId, int $quantity)
    {
        if ($quantity < 1) {
            return;
        }

        $item = CartItem::findOrFail($itemId);
        $item->quantity = $quantity;
        $item->total = $item->price * $quantity;
        $item->save();

        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function removeItem(int $itemId)
    {
        $item = CartItem::findOrFail($itemId);
        $item->delete();

        if ($item->cart->items()->count() === 0) {
            $item->cart->delete();
        }

        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('Website::livewire.cart.cart-list');
    }
}
