<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Modules\Website\Services\CartService;
use Illuminate\Support\Facades\App;

class CartList extends Component
{
    public $couponCodeInput = '';

    // Inject Service (Laravel 12 style hoặc boot)
    protected function getCartService()
    {
        return App::make(CartService::class);
    }

    #[Computed]
    public function cartData()
    {
        return $this->getCartService()->getCartSummary();
    }

    public function increment($itemId)
    {
        $item = $this->cartData['items']->where('id', $itemId)->first();
        if ($item) {
            try {
                $this->getCartService()->updateQuantity($itemId, $item->quantity + 1);
                $this->dispatch('cart-updated'); // Để update header cart number nếu có
            } catch (\Exception $e) {
                $this->dispatch('notify', ['type' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function decrement($itemId)
    {
        $item = $this->cartData['items']->where('id', $itemId)->first();
        if ($item && $item->quantity > 1) {
            $this->getCartService()->updateQuantity($itemId, $item->quantity - 1);
            $this->dispatch('cart-updated');
        }
    }

    public function remove($itemId)
    {
        $this->getCartService()->removeItem($itemId);
        $this->dispatch('cart-updated');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã xóa sản phẩm']);
    }

    public function applyCoupon()
    {
        try {
            $this->getCartService()->applyCoupon($this->couponCodeInput);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Áp dụng mã giảm giá thành công!']);
            $this->couponCodeInput = ''; // Reset input
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function removeCoupon()
    {
         $this->getCartService()->removeCoupon();
         $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã gỡ mã giảm giá']);
    }

    public function render()
    {
        return view('Website::livewire.cart.cart-list');
    }
}
