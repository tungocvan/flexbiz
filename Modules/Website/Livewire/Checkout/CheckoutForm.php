<?php

namespace Modules\Website\Livewire\Checkout;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Website\Models\Cart;
use Modules\Website\Models\Order;
use Modules\Website\Models\OrderItem;
use Modules\Website\Http\Requests\CheckoutRequest;

class CheckoutForm extends Component
{
    public string $customer_name = '';
    public string $customer_phone = '';
    public ?string $customer_email = null;
    public string $customer_address = '';
    public ?string $note = null;

    protected function rules()
    {
        return (new CheckoutRequest())->rules();
    }

    public function submit()
    {
        $validated = $this->validate();

        $cart = Cart::with('items.product')
            ->where('session_id', session()->getId())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            abort(404);
        }

        DB::transaction(function () use ($cart, $validated) {

            $subtotal = $cart->items->sum('total');
            $discount = 0;
            $total    = $subtotal - $discount;

            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_code'       => strtoupper(Str::random(10)),
                'customer_name'    => $validated['customer_name'],
                'customer_phone'   => $validated['customer_phone'],
                'customer_email'   => $validated['customer_email'] ?? null,
                'customer_address' => $validated['customer_address'],
                'note'             => $validated['note'] ?? null,
                'subtotal'         => $subtotal,
                'discount'         => $discount,
                'total'            => $total,
                'status'           => 'pending',
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product?->title ?? '',
                    'price'        => $item->price,
                    'quantity'     => $item->quantity,
                    'total'        => $item->total,
                ]);
            }

            $cart->items()->delete();
            $cart->delete();

            session()->forget('cart_id');


            return redirect()->route('website.checkout.success', $order->order_code);

        });
    }

    public function render()
    {
        return view('Website::livewire.checkout.checkout-form');
    }
}
