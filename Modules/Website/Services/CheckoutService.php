<?php

namespace Modules\Website\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Modules\Website\Models\Cart;
use Modules\Website\Models\Order;
use Modules\Website\Models\OrderItem;
use Exception;

class CheckoutService
{
    protected $affiliateService;

    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
    }

    /**
     * Xử lý tạo đơn hàng (Transaction)
     */
    public function createOrder(array $data)
    {
        $sessionId = Session::getId();
        $cart = Cart::with(['items.product'])->where('session_id', $sessionId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new Exception('Giỏ hàng trống.');
        }

        return DB::transaction(function () use ($cart, $data) {
            // 1. Kiểm tra tồn kho
            foreach ($cart->items as $cartItem) {
                $product = $cartItem->product;
                if (!$product || !$product->is_active) {
                    throw new Exception("Sản phẩm '{$cartItem->product_name}' không khả dụng.");
                }
                if ($product->quantity < $cartItem->quantity) {
                    throw new Exception("Sản phẩm '{$product->title}' không đủ số lượng tồn kho.");
                }
            }

            // 2. Xử lý Affiliate
            $affiliateId = $this->affiliateService->getValidAffiliateId();
            $subtotal = $cart->items->sum('total');
            $commissionAmount = $affiliateId ? $this->affiliateService->calculateCommission($subtotal) : 0;

            // 3. Tạo Order
            $initialStatus = match ($data['payment_method']) {
                'momo', 'vnpay' => 'pending_payment',
                default => 'pending',
            };

            $order = Order::create([
                'user_id'           => Auth::id(),
                'affiliate_id'      => $affiliateId,
                'commission_status' => $affiliateId ? 'pending' : 'none',
                'commission_amount' => $commissionAmount,
                'order_code'        => 'ORD-' . strtoupper(uniqid()) . rand(100, 999),
                
                'customer_name'     => $data['customer_name'],
                'customer_phone'    => $data['customer_phone'],
                'customer_email'    => $data['customer_email'],
                'customer_address'  => $data['customer_address'],
                'note'              => $data['note'] ?? null,
                
                'subtotal'          => $subtotal,
                'shipping_fee'      => 0, // Logic shipping tính sau
                'discount'          => 0, // Logic coupon tính sau
                'total'             => $subtotal, // + ship - discount
                'status'            => $initialStatus,
                'payment_method'    => $data['payment_method'],
            ]);

            // 4. Tạo Order Items & Trừ kho
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->title,
                    'price'        => $item->price,
                    'quantity'     => $item->quantity,
                    'total'        => $item->total,
                ]);

                // Trừ kho & Tăng lượt bán
                $item->product->decrement('quantity', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }

            // 5. Xóa giỏ hàng
            $cart->delete();

            return $order;
        });
    }
}