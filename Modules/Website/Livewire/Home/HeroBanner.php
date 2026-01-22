<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Services\MarketingService;

class HeroBanner extends Component
{
    public array $slides = [];

    public function mount(MarketingService $service)
    {
        $this->slides = $service->getHeroSlides();
    }

    public function render()
    {

        return view('Website::livewire.home.hero-banner');
    }
}
