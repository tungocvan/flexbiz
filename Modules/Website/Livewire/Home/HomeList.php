<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;

class HomeList extends Component
{
    /**
     * Render the orchestrator view.
     */
    public function render()
    {
        // View namespace theo quy ước mapping trong Master Prompt
        return view('Website::livewire.home.home-list');
    }
}
