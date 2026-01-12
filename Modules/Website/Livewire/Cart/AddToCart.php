<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;
use Modules\Website\Models\WpProduct;

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function addToCart()
    {
        $sessionId = Session::getId();
        $product = WpProduct::find($this->productId);

        if (!$product) return;

        // 1. Lấy hoặc tạo Cart theo Session
        $cart = Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => auth()->id()]
        );

        // 2. Kiểm tra sản phẩm trong giỏ
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $this->productId)
            ->first();

        $price = $product->final_price; // Dùng accessor đã tạo ở Model

        if ($cartItem) {
            // Update số lượng
            $cartItem->quantity += $this->quantity;
            $cartItem->total = $cartItem->quantity * $price;
            $cartItem->save();
        } else {
            // Tạo mới item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $this->productId,
                'price' => $price,
                'quantity' => $this->quantity,
                'total' => $price * $this->quantity,
            ]);
        }

        // 3. Dispatch event để update Icon
        $this->dispatch('cart-updated');

        // Thông báo (tùy chọn, dùng session flash hoặc dispatch browser event)
        session()->flash('success', 'Đã thêm vào giỏ hàng!');
    }

    public function render()
    {
        return view('Website::livewire.cart.add-to-cart');
    }
}
