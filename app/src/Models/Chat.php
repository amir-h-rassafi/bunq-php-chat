<?php
namespace App\Models;

// Assume as session, maybe in 2 or more person

class Chat extends BaseModel
{
    protected $table = 'chats';

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_user_id')->select('id', 'username');
    }
}
