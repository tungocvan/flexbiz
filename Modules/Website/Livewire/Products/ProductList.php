<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
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
    public $search = '';
    public $sort = 'latest';

    // LẮNG NGHE SỰ KIỆN TỪ CON
    #[On('search-updated')]
    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage(); // Quan trọng: Reset về trang 1 khi tìm kiếm
    }

    // LẮNG NGHE SỰ KIỆN TỪ COMPONENT CON
    #[On('filter-category-updated')]
    public function updateCategoryFilter($slug)
    {
        $this->categorySlug = $slug;
        $this->resetPage(); // Reset về trang 1 khi đổi filter
    }

    // 2. LẮNG NGHE SỰ KIỆN SORT
    #[On('sort-updated')]
    public function updateSort($sort)
    {
        $this->sort = $sort;
        // Không nhất thiết phải reset trang, nhưng reset thì UX tốt hơn
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'Website::livewire.partials.pagination';
    }

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

    public function render()
    {
        $query = WpProduct::active(); // Bỏ latest() ở đây để xử lý bên dưới

        // Logic Search (Giữ nguyên)
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description', 'like', '%' . $this->search . '%');
            });
        }

        // Logic Category (Giữ nguyên)
        if ($this->categorySlug) {
            $category = Category::where('slug', $this->categorySlug)->first();
            if ($category) {
                $category->load('childrenRecursive');
                $categoryIds = $category->getAllChildrenIds();
                $query->whereHas('categories', fn ($q) =>
                    $q->whereIn('categories.id', $categoryIds)
                );
            }
        }

        // 3. LOGIC SẮP XẾP (SORTING)
        switch ($this->sort) {
            case 'price_asc':
                // Sắp xếp theo giá thực tế (Ưu tiên Sale Price nếu có)
                // COALESCE(sale_price, regular_price) -> Lấy sale_price, nếu null thì lấy regular_price
                $query->orderByRaw('COALESCE(sale_price, regular_price) ASC');
                break;

            case 'price_desc':
                $query->orderByRaw('COALESCE(sale_price, regular_price) DESC');
                break;

            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'latest':
            default:
                $query->latest(); // created_at desc
                break;
        }

        return view('Website::livewire.products.product-list', [
            'products' => $query->paginate(12)
        ]);
    }
}
