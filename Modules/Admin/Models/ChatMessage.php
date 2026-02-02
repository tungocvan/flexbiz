<?php
namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['chat_session_id', 'sender_id', 'sender_type', 'message', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(ChatSession::class, 'chat_session_id');
    }
}
