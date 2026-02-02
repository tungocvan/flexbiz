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

    public function getListeners()
    {
        return [
            // Lắng nghe từ Echo (NodeJS)
            "echo:chat,.MessageSent" => 'handleIncoming',
            // Lắng nghe lệnh refresh từ Javascript nội bộ
            '$refresh' => '$refresh',
            'refresh-widget' => '$refresh'
        ];
    }

    public function handleIncoming($data)
    {
        // Lấy session hiện tại dựa trên token của khách
        $session = ChatSession::where('session_token', $this->sessionToken)->first();

        // CHỈ REFRESH NẾU: Tin nhắn bay về thuộc đúng ID của phiên chat này
        if ($session && isset($data['session_id']) && $data['session_id'] == $session->id) {
            $this->dispatch('$refresh');
            $this->dispatch('scroll-bottom');
        }
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
        $messages = [];
        if ($this->step === 'chat') {
            $session = \Modules\Admin\Models\ChatSession::where('session_token', $this->sessionToken)
                ->with(['messages' => fn($q) => $q->orderBy('created_at', 'asc')])
                ->first();

            $messages = $session ? $session->messages : [];
        }

        return view('Website::livewire.chat.chat-widget', [
            'messages' => $messages
        ]);
    }
}
