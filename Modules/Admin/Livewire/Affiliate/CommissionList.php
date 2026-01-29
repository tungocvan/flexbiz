<?php

namespace Modules\Admin\Livewire\Affiliate;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Admin\Services\AdminAffiliateService;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

class CommissionList extends Component
{
    use WithPagination;

    #[Url]
    public $statusFilter = 'all'; 
    
    #[Url]
    public $search = '';

    // State cho Modal chi tiết
    public $selectedOrder = null;
    public $isModalOpen = false;

    // State cho việc từ chối
    public $showRejectForm = false;
    public $rejectionReason = '';

    protected $queryString = [
        'statusFilter' => ['except' => 'all'],
        'search' => ['except' => '']
    ];

    /**
     * Mở Modal xem chi tiết và đối soát hoa hồng
     */
    public function openDetail($orderId, AdminAffiliateService $service)
    {
        $this->selectedOrder = $service->getOrderDetail($orderId);
        $this->isModalOpen = true;
        $this->showRejectForm = false;
        $this->rejectionReason = '';
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->selectedOrder = null;
    }

    /**
     * Duyệt hoa hồng
     */
    public function approve($orderId, AdminAffiliateService $service)
    {
        try {
            $service->approve($orderId);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã duyệt hoa hồng thành công!']);
            
            if ($this->isModalOpen) {
                $this->selectedOrder = $service->getOrderDetail($orderId);
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Từ chối hoa hồng kèm lý do
     */
    public function reject(AdminAffiliateService $service)
    {
        $this->validate([
            'rejectionReason' => 'required|min:5'
        ], [
            'rejectionReason.required' => 'Vui lòng nhập lý do từ chối.',
            'rejectionReason.min' => 'Lý do quá ngắn.'
        ]);

        try {
            $service->reject($this->selectedOrder->id, $this->rejectionReason);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã từ chối hoa hồng.']);
            
            $this->showRejectForm = false;
            $this->selectedOrder = $service->getOrderDetail($this->selectedOrder->id);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    #[On('refresh-commission-list')]
    public function refreshList()
    {
        // Livewire tự động render lại
    }

    public function render(AdminAffiliateService $service)
    {
        $filters = [
            'status' => $this->statusFilter,
            'search' => $this->search
        ];

        return view('Admin::livewire.affiliate.commission-list', [
            'commissions' => $service->getCommissions($filters)
        ]);
    }
}