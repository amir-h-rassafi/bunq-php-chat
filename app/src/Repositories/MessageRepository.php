<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Database\Capsule\Manager as DB;

class MessageRepository extends BaseRepository
{
    public function getById($id): ?Message
    {
        return Message::find($id);
    }

    public function getMessages(int $chatId, int $count)
    {
        return Message::where('chat_id', '=', $chatId)
            ->orderby('id', 'DESC')
            ->limit($count)
            ->get();
    }

    public function getMessagesJson(int $chatId, int $count)
    {
        return Message::where('chat_id', '=', $chatId)
        ->orderby('id', 'DESC')
        ->limit($count)
        ->with('user')
        ->get();
    }

    public function addMessage(int $userId, int $chatId, string $messageText): Message
    {
        $message = new Message;
        
        $message->user_id = $userId;
        $message->chat_id = $chatId;
        $message->message = $messageText;

        $message->save();

        return $message;
    }
}
