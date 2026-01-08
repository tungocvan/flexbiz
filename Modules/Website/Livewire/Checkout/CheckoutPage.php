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
        $this->validate();

        $order = Order::create([
            'code' => 'ORD-' . strtoupper(Str::random(8)),
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'total' => $this->total,
            'payment_method' => 'cod',
        ]);

        foreach ($this->cart as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('website.checkout.success', $order->code);
    }

    public function render()
    {
        return view('Website::livewire.checkout.checkout-page')
            ->layout('Website::layouts.website');
    }
}
