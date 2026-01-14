<?php

namespace Modules\Admin\Livewire\Dashboard;

use Livewire\Component;

class StatsOverview extends Component
{
    // Logic đếm số liệu sẽ nằm ở đây
    public $totalOrders = 150;
    public $revenue = 50000000;

    public function render()
    {
        return view('Admin::livewire.dashboard.stats-overview');
    }
}
