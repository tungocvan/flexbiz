<?php

namespace Modules\Website\Livewire\Checkout;

use Livewire\Component;
use Illuminate\Support\Str;
use Modules\Website\Models\Order;

class CheckoutPage extends Component
{
    public array $cart = [];

    public string $name = '';
    public string $phone = '';
    public string $address = '';

    protected $rules = [
        'name'    => 'required|min:3',
        'phone'   => 'required|min:8',
        'address' => 'required|min:10',
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);

        if (empty($this->cart)) {
            redirect()->route('website.cart');
        }
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(fn ($item) =>
            $item['price'] * $item['qty']
        );
    }

    public function placeOrder()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $this->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($cart) {

            $subtotal = collect($cart)->sum(fn ($item) =>
                $item['price'] * $item['qty']
            );

            $discount = 0;
            $total = $subtotal - $discount;

            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_code'       => $this->generateOrderCode(),
                'customer_name'    => $this->name,
                'customer_phone'   => $this->phone,
                'customer_email'   => $this->email,
                'customer_address' => $this->address,
                'note'             => $this->note,
                'subtotal'         => $subtotal,
                'discount'         => $discount,
                'total'            => $total,
                'status'           => 'pending',
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'] ?? null,
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'quantity'     => $item['qty'],
                    'total'        => $item['price'] * $item['qty'],
                ]);
            }
        });

        session()->forget('cart');

        return redirect()->route('order.success');
    }

    protected function generateOrderCode()
    {
        return 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
    }

    public function render()
    {
        return view('Website::livewire.checkout.checkout-page')
            ->layout('Website::layouts.website');
    }
}
