<?php
namespace App\Models;

class Message extends BaseModel
{
    protected $table = 'messages';

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }
}
