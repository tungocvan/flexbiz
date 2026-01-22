<?php

namespace Modules\Admin\Livewire\Affiliate;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Admin\Services\AdminAffiliateService;
use Livewire\Attributes\On;

class CommissionList extends Component
{
    use WithPagination;

    public $statusFilter = 'all'; // all, pending, approved, rejected
    public $search = '';

    protected $queryString = ['statusFilter', 'search'];

    public function approve($orderId, AdminAffiliateService $service)
    {
        try {
            $service->approve($orderId);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã duyệt hoa hồng thành công!']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function reject($orderId, AdminAffiliateService $service)
    {
        try {
            $service->reject($orderId);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã từ chối hoa hồng.']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    #[On('refresh-commission-list')] // <--- Thêm hàm này
    public function refreshList()
    {
        // Hàm này rỗng cũng được, Livewire sẽ tự render lại component
        // khi nhận sự kiện, giúp cập nhật danh sách mới nhất.
    }

    public function render(AdminAffiliateService $service)
    {
        $filters = [
            'status' => $this->statusFilter,
            'search' => $this->search
        ];

        $commissions = $service->getCommissions($filters);

        return view('Admin::livewire.affiliate.commission-list', [
            'commissions' => $commissions
        ]);
    }
}