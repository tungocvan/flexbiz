<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Website\Models\Order;

class AccountController extends Controller
{
    public function index()
    {
        // Đếm tổng số đơn hàng của User hiện tại
        $totalOrders = Order::where('user_id', auth()->id())->count();

        // Truyền biến sang view
        return view('Website::account.dashboard', compact('totalOrders'));
    }

    public function orders()
    {
        return view('Website::account.orders.index');
    }

    public function orderDetail($code)
    {
        return view('Website::account.orders.show', compact('code'));
    }
}
