<?php

namespace Modules\Admin\Livewire\Chat;

use Livewire\Component;
use Modules\Admin\Models\ChatSession;
use Modules\Admin\Services\ChatService;
use Illuminate\Support\Facades\Auth;

class ChatManager extends Component
{
    public $activeSessionId = null;
    public $message = '';

    // Lắng nghe sự kiện từ Echo (NodeJS) và sự kiện nội bộ
    public function getListeners()
    {
        return [
            "echo:chat,.MessageSent" => 'refreshChat', // Dấu chấm (.) là bắt buộc
            "refresh-chat" => '$refresh',
        ];
    }

    public function selectSession($id)
    {
        $this->activeSessionId = $id;

        // Gán Admin tiếp nhận nếu chưa có
        $session = ChatSession::find($id);
        if ($session && !$session->admin_id) {
            $session->update(['admin_id' => Auth::id()]);
        }

        $this->dispatch('scroll-chat-to-bottom');
    }

    public function refreshChat($data) {
        // Logic lọc hoặc xử lý nếu cần
        $this->dispatch('refresh-chat'); // Nó sẽ kích hoạt listener "$refresh" ở trên
    }

    public function send(ChatService $chatService)
    {
        if (!$this->activeSessionId || empty(trim($this->message))) return;

        // Gọi Service xử lý nghiệp vụ lưu và bắn Socket
        $chatService->sendMessage([
            'session_id'  => $this->activeSessionId,
            'sender_id'    => Auth::id(),
            'sender_type'  => 'admin',
            'message'      => $this->message,
        ]);

        $this->message = '';
        $this->dispatch('scroll-chat-to-bottom');
    }

    public function render()
    {
        return view('Admin::livewire.chat.chat-manager', [
            'sessions' => ChatSession::with('user')
                ->orderBy('updated_at', 'desc')
                ->limit(20)
                ->get(),
            'activeSession' => $this->activeSessionId
                ? ChatSession::with(['messages' => fn($q) => $q->orderBy('created_at', 'asc')])
                    ->find($this->activeSessionId)
                : null,
        ]);
    }
}
