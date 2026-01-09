<?php

namespace Modules\Website\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Website\Models\Order;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('Website::checkout.index');
    }

    public function success(string $orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();

        return view('Website::checkout.success', compact('order'));
    }
}
