<?php

namespace Modules\Website\Livewire\Checkout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Website\Http\Requests\CheckoutRequest;
use Modules\Website\Services\CheckoutService;

class CheckoutForm extends Component
{
    // Properties
    public $customer_name;
    public $customer_phone;
    public $customer_email;
    public $customer_address;
    public $note;
    public $payment_method = 'cod';

    // Validation Rules từ Request Class
    protected function rules()
    {
        return (new CheckoutRequest())->rules();
    }

    protected function messages()
    {
        return (new CheckoutRequest())->messages();
    }

    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->customer_name = $user->name;
            $this->customer_email = $user->email;
            // $this->customer_phone = $user->phone; 
            // $this->customer_address = $user->address;
        }
    }

    /**
     * Hành động đặt hàng - Gọi Service
     */
    public function placeOrder(CheckoutService $checkoutService)
    {
        $this->validate();

        try {
            // Chuẩn bị dữ liệu
            $data = [
                'customer_name'    => $this->customer_name,
                'customer_phone'   => $this->customer_phone,
                'customer_email'   => $this->customer_email,
                'customer_address' => $this->customer_address,
                'note'             => $this->note,
                'payment_method'   => $this->payment_method,
            ];

            // Gọi Service để xử lý Transaction
            $order = $checkoutService->createOrder($data);

            // Logic sau khi thành công
            Session::regenerate(); // Bảo mật
            session()->flash('success_message', 'Đặt hàng thành công!');
            session()->flash('order_code', $order->order_code);

            return redirect()->route('checkout.success');

        } catch (\Exception $e) {
            // Xử lý lỗi từ Service ném ra
            $this->addError('system', $e->getMessage());
        }
    }

    public function render()
    {
        return view('Website::livewire.checkout.checkout-form');
    }
}