<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Modules\Website\Models\WpProduct;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;
use Illuminate\Support\Facades\Session;

class Show extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->product = WpProduct::active()
            ->with('categories')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function addToCart()
    {
        $this->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Lấy hoặc tạo giỏ hàng dựa trên Session
        $sessionId = Session::getId();
        $cart = Cart::firstOrCreate(['session_id' => $sessionId]);

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $cartItem = $cart->items()->where('product_id', $this->product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $this->quantity);
            $cartItem->update(['total' => $cartItem->quantity * $cartItem->price]);
        } else {
            $cart->items()->create([
                'product_id' => $this->product->id,
                'price' => $this->product->final_price,
                'quantity' => $this->quantity,
                'total' => $this->product->final_price * $this->quantity
            ]);
        }

        // Bắn sự kiện cập nhật số lượng giỏ hàng trên Header (Bước 5)
        $this->dispatch('cartUpdated');

        // Thông báo cho người dùng
        $this->dispatch('notify', message: 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function render()
    {
        return view('Website::livewire.products.show')
            ->layout('Website::layouts.website', [
                'meta_title' => $this->product->title
            ]);
    }
}