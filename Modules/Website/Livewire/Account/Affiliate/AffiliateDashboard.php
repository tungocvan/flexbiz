<?php

namespace Modules\Website\Livewire\Account\Affiliate;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Modules\Website\Services\AffiliateService;

class AffiliateDashboard extends Component
{
    use WithPagination;

    // Biến để generate link
    public $referralCode;
    public $referralLink;

    public function mount()
    {
        $user = Auth::user();
        $this->referralCode = $user->id; // Dùng ID làm mã ref (đơn giản nhất)
        // Tạo link mặc định là trang chủ kèm ref
        $this->referralLink = route('home', ['ref' => $this->referralCode]);
    }

    public function render(AffiliateService $service)
    {
        $userId = Auth::id();
        $stats = $service->getStats($userId);
        $commissions = $service->getCommissionHistory($userId);

        return view('Website::livewire.account.affiliate.affiliate-dashboard', [
            'stats' => $stats,
            'commissions' => $commissions
        ]);
    }
}