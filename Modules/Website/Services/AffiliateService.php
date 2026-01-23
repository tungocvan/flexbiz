<?php

namespace Modules\Website\Services;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Modules\Website\Models\Order;

class AffiliateService
{
    /**
     * Lấy ID người giới thiệu hợp lệ từ Cookie
     */
    public function getValidAffiliateId(): ?int
    {
        $affiliateId = Cookie::get('affiliate_ref');

        // Logic bảo vệ: Nếu User đang login trùng với ID trong cookie -> Hủy (Không tự ref)
        if (Auth::check() && Auth::id() == $affiliateId) {
            return null;
        }

        return $affiliateId ? (int)$affiliateId : null;
    }

    /**
     * Tính toán hoa hồng (Ví dụ: 10% giá trị đơn hàng)
     */
    public function calculateCommission(float $orderSubtotal): float
    {
        return $orderSubtotal * 0.10;
    }

    /**
     * Lấy thống kê tổng quan cho User
     */
    public function getStats($userId)
    {
        // Lấy tất cả đơn hàng do user này giới thiệu
        $query = Order::where('affiliate_id', $userId);

        return [
            // Tổng thu nhập (Đã duyệt)
            'total_earnings' => $query->clone()
                ->where('commission_status', 'approved')
                ->sum('commission_amount'),

            // Thu nhập chờ duyệt (Đơn mới đặt, chưa đối soát)
            'pending_earnings' => $query->clone()
                ->where('commission_status', 'pending')
                ->sum('commission_amount'),

            // Tổng số đơn hàng giới thiệu thành công
            'total_orders' => $query->count(),
        ];
    }

    /**
     * Lấy lịch sử hoa hồng (Có lọc trạng thái)
     */
    public function getCommissionHistory($userId, $status = 'all', $limit = 10)
    {
        return Order::where('affiliate_id', $userId)
            ->with(['items']) // Eager load sản phẩm để hiển thị trong modal
            ->when($status !== 'all', function ($q) use ($status) {
                $q->where('commission_status', $status);
            })
            ->select('id', 'order_code', 'customer_name', 'total', 'commission_amount', 'commission_status', 'rejection_reason', 'created_at')
            ->latest()
            ->paginate($limit);
    }

    /**
     * Lấy chi tiết 1 đơn hàng của Affiliate (Để xem modal)
     */
    public function getAffiliateOrderDetail($orderId, $affiliateId)
    {
        return Order::where('id', $orderId)
            ->where('affiliate_id', $affiliateId) // Bảo mật: Chỉ xem được đơn mình giới thiệu
            ->with('items')
            ->firstOrFail();
    }
}
