<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Models\Newsletter;

class NewsletterSignup extends Component
{
    public $email = '';
    public $subscribed = false;

    // Rules validation
    protected $rules = [
        'email' => 'required|email|unique:newsletters,email',
    ];

    protected $messages = [
        'email.required' => 'Vui lòng nhập email của bạn.',
        'email.email' => 'Email không đúng định dạng.',
        'email.unique' => 'Email này đã được đăng ký rồi.',
    ];

    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    public function subscribe()
    {
        $this->validate();

        // Lưu vào DB
        Newsletter::create(['email' => $this->email]);

        // Giả lập độ trễ mạng để hiển thị loading cho đẹp
        sleep(1);

        $this->subscribed = true;
        $this->reset('email');
    }

    // Placeholder khi Lazy Load
    public function placeholder()
    {
        return <<<'blade'
        <div class="container mx-auto px-4 mb-20">
            <div class="w-full h-64 bg-gray-100 rounded-3xl animate-pulse"></div>
        </div>
        blade;
    }

    public function render()
    {
        return view('Website::livewire.home.newsletter-signup');
    }
}
