<?php

namespace Modules\Admin\Services;

use Modules\Website\Models\Order;
use Exception;

class AdminAffiliateService
{
    /**
     * Lấy danh sách hoa hồng (Có phân trang & bộ lọc)
     */
    public function getCommissions(array $filters = [], int $perPage = 10)
    {
        return Order::whereNotNull('affiliate_id')
            ->with(['affiliate', 'user']) // Eager load người giới thiệu & người mua
            ->when(isset($filters['status']) && $filters['status'] !== 'all', function ($q) use ($filters) {
                $q->where('commission_status', $filters['status']);
            })
            ->when(isset($filters['search']), function ($q) use ($filters) {
                $q->where('order_code', 'like', '%' . $filters['search'] . '%');
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Duyệt hoa hồng
     */
    public function approve($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->commission_status === 'approved') {
            throw new Exception('Hoa hồng này đã được duyệt trước đó.');
        }

        $order->update(['commission_status' => 'approved']);
        
        // TODO: Tại đây có thể bắn Notification cho Affiliate User
        // hoặc cộng tiền vào Ví thực (Wallet) nếu hệ thống có ví.
        
        return $order;
    }

    /**
     * Từ chối hoa hồng kèm lý do
     */
    public function reject($orderId, $reason)
    {
        $order = Order::findOrFail($orderId);
        
        // Chỉ cho phép từ chối nếu chưa xử lý
        if ($order->commission_status !== 'pending') {
            throw new Exception('Trạng thái đơn hàng không hợp lệ để từ chối.');
        }

        $order->update([
            'commission_status' => 'rejected',
            'rejection_reason'  => $reason
        ]);

        return $order;
    }
    public function getOrderDetail($orderId)
    {
        return Order::with(['items', 'user', 'affiliate'])
            ->findOrFail($orderId);
    }
    
}