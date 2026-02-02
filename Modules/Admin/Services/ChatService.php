<?php

namespace Modules\Admin\Services;

use Modules\Admin\Models\ChatSession;
use Modules\Admin\Models\ChatMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ChatService
{
    /**
     * Gửi tin nhắn và bắn tín hiệu sang NodeJS
     */
    public function sendMessage(array $data)
    {
        return DB::transaction(function () use ($data) {
            $message = ChatMessage::create([
                'chat_session_id' => $data['session_id'],
                // Nếu là guest thì ép kiểu về null để tránh lỗi SQL
                'sender_id'       => $data['sender_type'] === 'guest' ? null : $data['sender_id'],
                'sender_type'     => $data['sender_type'],
                'message'         => $data['message'],
            ]);

            // Bridge sang NodeJS (giữ nguyên)
            // Trong Modules/Admin/Services/ChatService.php
            $this->broadcastToNodeJS([
                'channel' => 'chat',
                'event'   => 'MessageSent', // Đây là biến {event} trong NodeJS
                'data'    => [
                    'session_id' => $data['session_id'],
                    'message'    => $message->message,
                    'sender_type'=> $message->sender_type
                ]
            ]);

            return $message;
        });
    }

    /**
     * Tìm hoặc tạo Session cho Guest
     */
    public function getOrCreateGuestSession($token)
    {
        return ChatSession::firstOrCreate(
            ['session_token' => $token],
            ['status' => 'open']
        );
    }

    /**
     * Bridge: Gửi HTTP Request sang NodeJS Server
     */
    protected function broadcastToNodeJS(array $payload)
    {
        try {
            $url = config('services.nodejs.url', env('NODEJS_SERVER_URL')) . '/broadcast';
            Http::timeout(3)->post($url, $payload);
        } catch (\Exception $e) {
            // Ghi log nếu NodeJS server die, nhưng không làm chết luồng Laravel
            \Log::error("Socket Bridge Error: " . $e->getMessage());
        }
    }
}
