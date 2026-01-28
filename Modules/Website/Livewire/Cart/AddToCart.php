<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;
use Modules\Website\Models\WpProduct; // Model sản phẩm của bạn

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;
    public $style = 'default'; // Các kiểu: 'default' (trang chi tiết), 'circle-orange' (nút tròn), 'simple' (nút chữ nhật nhỏ)

    public function mount($productId, $style = 'default')
    {
        $this->productId = $productId;
        $this->style = $style;
    }

    public function addToCart()
    {
        // 1. Kiểm tra sản phẩm
        $product = WpProduct::find($this->productId);
        if (!$product) {
            $this->dispatch('alert', type: 'error', message: 'Sản phẩm không tồn tại!');
            return;
        }

        // 2. Xác định Giỏ hàng (User hoặc Session)
        $userId = Auth::id();
        $sessionId = Session::getId();

        if ($userId) {
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
        } else {
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        // 3. Kiểm tra sản phẩm trong giỏ
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $this->productId)
            ->first();

        // Lấy giá ưu tiên Sale Price
        $price = $product->sale_price > 0 ? $product->sale_price : $product->regular_price;

        if ($cartItem) {
            // Update số lượng
            $cartItem->quantity += $this->quantity;
            $cartItem->total = $cartItem->quantity * $price; // Cập nhật tổng tiền item
            $cartItem->save();
        } else {
            // Tạo mới item
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $this->productId,
                'price'      => $price,
                'quantity'   => $this->quantity,
                'total'      => $price * $this->quantity,
            ]);
        }

        // 4. Phản hồi giao diện
        // Update số lượng trên Header Cart (Icon giỏ hàng)
        $this->dispatch('cart-updated');

        // Hiển thị thông báo (Toast)
        $this->dispatch('alert', type: 'success', message: 'Đã thêm vào giỏ hàng!');

        // Reset số lượng về 1 (nếu là giao diện mặc định)
        if ($this->style === 'default') {
            $this->quantity = 1;
        }
    }

    public function render()
    {
        return view('Website::livewire.cart.add-to-cart');
    }
}
