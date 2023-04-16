<?php
namespace App\Models;

class Message extends BaseModel
{
    protected $table = 'messages';

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id')->select('id', 'username');
    }

    public function chatMeta()
    {
        return $this->belongsTo(Chat::class, 'chat_id')->select('id', 'receiver_user_id')->with('receiver');
    }
}
