<?php

namespace Modules\Website\Livewire;

use Livewire\Component;

class TestPage extends Component
{


    public function render()
    {

       return view('Website::livewire.test-page')->layout('components.layouts.app');

    }

    public function test()
    {
        dd('oki');
        $this->dispatch('notify', ['message' => 'Livewire OK']);
    }
}
