<?php

namespace App\Repositories;

use App\Models\Chat;
use Illuminate\Database\Capsule\Manager as DB;

class ChatRepository extends BaseRepository
{
    public function getUserById($id): ?Chat
    {
        return Chat::find($id);
    }

    public function addChat(): Chat
    {
        $chat = new Chat;   
        $chat->save();
        return $chat;
    }
}
