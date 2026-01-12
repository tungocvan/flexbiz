<?php

namespace Modules\Website\Livewire\Checkout;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\Cart;
use Modules\Website\Models\Order;
use Modules\Website\Models\OrderItem;
use Modules\Website\Http\Requests\CheckoutRequest;

class CheckoutForm extends Component
{
    public $customer_name;
    public $customer_phone;
    public $customer_email;
    public $customer_address;
    public $note;

    // Dùng rules từ Request class
    protected function rules()
    {
        return (new CheckoutRequest())->rules();
    }

    protected function messages()
    {
        return (new CheckoutRequest())->messages();
    }

    public function placeOrder()
    {
        $this->validate();

        $sessionId = Session::getId();
        $cart = Cart::with('items.product')->where('session_id', $sessionId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('website.cart.index');
        }

        DB::beginTransaction();

        try {
            // 1. Tạo Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => $this->customer_name,
                'customer_phone' => $this->customer_phone,
                'customer_email' => $this->customer_email,
                'customer_address' => $this->customer_address,
                'note' => $this->note,
                'subtotal' => $cart->items->sum('total'),
                'discount' => 0,
                'total' => $cart->items->sum('total'),
                'status' => 'pending'
            ]);

            // 2. Tạo Order Items
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

            // 3. Xóa giỏ hàng
            $cart->delete(); // Cascade sẽ xóa luôn cart_items

            // 4. Commit và Regenerate Session để tránh duplicate form
            DB::commit();
            Session::regenerate();

            // 5. Lưu flash session để hiện ở trang success
            session()->flash('order_code', $order->order_code);

            return redirect()->route('website.checkout.success');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('system', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('Website::livewire.checkout.checkout-form');
    }
}
