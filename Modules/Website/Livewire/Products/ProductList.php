<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\WpProduct;
use Modules\Website\Models\Category;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;

class ProductList extends Component
{
    use WithPagination;
    // Biến lưu slug danh mục đang chọn (Mặc định null = Tất cả)
    public $categorySlug = null;

    // Reset phân trang về 1 khi đổi danh mục
    public function setCategory($slug)
    {
        $this->categorySlug = $slug;
        $this->resetPage();
    }
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

    // public function render()
    // {
    //     $products = WpProduct::active()
    //         ->latest()
    //         ->paginate(12);

    //     return view('Website::livewire.products.product-list', [
    //         'products' => $products
    //     ]);
    // }
    public function render()
    {
        // 1. Lấy danh sách danh mục CHA để hiển thị menu
        $categories = Category::active()->root()->orderBy('sort_order')->get();

        // 2. Query Sản phẩm cơ bản
        $query = WpProduct::active()->latest();

        // 3. Áp dụng Filter nếu có chọn danh mục
        if ($this->categorySlug) {
            $category = Category::where('slug', $this->categorySlug)->first();

            if ($category) {
                // TUÂN THỦ LUẬT: Lấy cả ID của danh mục con (Recursive)
                $category->load('childrenRecursive');
                $categoryIds = $category->getAllChildrenIds();

                $query->whereHas('categories', fn ($q) =>
                    $q->whereIn('categories.id', $categoryIds)
                );
            }
        }

        return view('Website::livewire.products.product-list', [
            'products' => $query->paginate(12),
            'categories' => $categories // Truyền biến này ra View
        ]);
    }
}
