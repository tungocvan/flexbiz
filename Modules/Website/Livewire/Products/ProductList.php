<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\WpProduct;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;

class ProductList extends Component
{
    use WithPagination;

    // Hàm thêm vào giỏ hàng nhanh (Mặc định số lượng 1)
    public function addToCart($productId)
    {
        $product = WpProduct::find($productId);
        if (!$product) return;

        $sessionId = Session::getId();

        // 1. Lấy hoặc tạo Cart
        $cart = Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => auth()->id()]
        );

        // 2. Check item trong cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        $price = $product->final_price;

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->total = $cartItem->quantity * $price;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => 1,
                'total' => $price,
            ]);
        }

        // 3. Dispatch event để update Cart Icon
        $this->dispatch('cart-updated');

        // 4. Thông báo (Optional: Dùng thư viện toast hoặc session flash)
        // session()->flash('message', "Đã thêm {$product->title} vào giỏ!");
    }

    public function render()
    {
        $products = WpProduct::active()
            ->latest()
            ->paginate(12);

        return view('Website::livewire.products.product-list', [
            'products' => $products
        ]);
    }
}
