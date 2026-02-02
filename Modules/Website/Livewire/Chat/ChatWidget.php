<?php
namespace Modules\Website\Livewire\Chat;

use Livewire\Component;
use Modules\Admin\Services\ChatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatWidget extends Component
{
    public $isOpen = false;
    public $step = 'auth'; // auth, chat
    public $message = '';
    public $sessionToken;
    public $guestInfo = ['name' => '', 'phone' => '', 'email' => ''];

    protected $listeners = [
        'echo:chat,.MessageSent' => 'handleIncoming'
    ];

    public function handleIncoming($data)
    {
        // Refresh giao diện người dùng
        $this->dispatch('$refresh');
        // Cuộn xuống cuối
        $this->dispatch('scroll-bottom');
    }

    public function mount()
    {
        // Kiểm tra Auth theo chuẩn Laravel
        if (Auth::check()) {
            $this->step = 'chat';
            $this->sessionToken = 'user_' . Auth::id();
        } else {
            $this->sessionToken = session()->get('chat_token', Str::random(32));
            session(['chat_token' => $this->sessionToken]);
        }
    }

    public function startChat(ChatService $chatService)
    {
        // Logic nghiệp vụ luôn nằm trong Service
        $chatService->getOrCreateGuestSession($this->sessionToken);
        $this->step = 'chat';
    }

    public function send(ChatService $chatService)
    {
        if (empty($this->message)) return;

        $session = $chatService->getOrCreateGuestSession($this->sessionToken);

        $chatService->sendMessage([
            'session_id'  => $session->id,
            'sender_id'    => Auth::id(),
            'sender_type'  => Auth::check() ? 'user' : 'guest',
            'message'      => $this->message,
        ]);

        $this->message = '';

        // Dispatch event để giao diện cuộn xuống
        $this->dispatch('scroll-bottom');
    }

    public function render()
    {
        return view('Website::livewire.chat.chat-widget');
    }
}
