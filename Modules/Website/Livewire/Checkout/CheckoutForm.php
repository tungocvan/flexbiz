<?php

namespace Modules\Website\Livewire\Checkout;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // Thêm Facade Auth
use Modules\Website\Models\Cart;
use Modules\Website\Models\Order;
use Modules\Website\Models\OrderItem;
use Modules\Website\Http\Requests\CheckoutRequest;
use Modules\Website\Services\MomoService;

class CheckoutForm extends Component
{
    public $customer_name;
    public $customer_phone;
    public $customer_email;
    public $customer_address;
    public $note;
    public $payment_method = 'cod'; // Mặc định là COD

    // Validation Rules (Giữ nguyên)
    protected function rules()
    {
        return (new CheckoutRequest())->rules();
    }

    protected function messages()
    {
        return (new CheckoutRequest())->messages();
    }

    // --- MỚI: TỰ ĐỘNG ĐIỀN THÔNG TIN NẾU ĐÃ LOGIN ---
    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->customer_name = $user->name;
            $this->customer_email = $user->email;

            // Nếu bảng users của bạn có phone/address thì gán luôn ở đây
            // $this->customer_phone = $user->phone;
            // $this->customer_address = $user->address;
        }
    }

    public function placeOrder()
    {
        $this->validate();

        // ... (Đoạn validation và kiểm tra giỏ hàng giữ nguyên) ...
        $sessionId = Session::getId();
        $cart = Cart::with('items.product')->where('session_id', $sessionId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        DB::beginTransaction();
        try {
            // 1. Tạo Order
            // Nếu chọn momo -> status là 'pending_payment' (Chờ thanh toán)
            // Nếu chọn cod  -> status là 'pending' (Chờ xử lý)
            $initialStatus = ($this->payment_method === 'momo') ? 'pending_payment' : 'pending';

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => $this->customer_name,
                'customer_phone' => $this->customer_phone,
                'customer_email' => $this->customer_email,
                'customer_address' => $this->customer_address,
                'note' => $this->note,
                'subtotal' => $cart->items->sum('total'),
                'discount' => 0,
                'total' => $cart->items->sum('total'),
                'status' => $initialStatus,
                'payment_method' => $this->payment_method
            ]);

            // 2. Tạo Items (Giữ nguyên)
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->title,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->total,
                ]);
            }

            // 3. Xóa Cart (Giữ nguyên)
            $cart->delete();
            DB::commit();
            Session::regenerate();

            // === KHÔNG GỌI API MOMO NỮA ===
            // Chỉ lưu mã đơn hàng vào flash session để hiển thị ở trang Success
            session()->flash('order_code', $order->order_code);

            // Chuyển hướng ngay lập tức
            return redirect()->route('checkout.success');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('system', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Lưu ý: Namespace view vẫn là Website:: (In hoa theo yêu cầu fix cứng của bạn)
        return view('Website::livewire.checkout.checkout-form');
    }
}
