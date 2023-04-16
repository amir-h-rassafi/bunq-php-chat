<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Database\Capsule\Manager as DB;
use App\Utils\Pager;

class MessageRepository extends BaseRepository
{
    public function getById($id): ?Message
    {
        return Message::find($id);
    }

    public function getMessages(int $chatId, Pager $pager)
    {
        return Message::where('chat_id', '=', $chatId)
            ->orderby('id', 'DESC')
            ->offset($pager->getOffset())
            ->limit($pager->size)
            ->get();
    }

    public function getMessagesJson(int $chatId, Pager $pager)
    {
        return Message::where('chat_id', '=', $chatId)
        ->orderby('id', 'DESC')
        ->offset($pager->getOffset())
        ->limit($pager->size)
        ->with('user')
        ->get();
    }

    public function addMessage(int $senderUserId, int $chatId, string $messageText): Message
    {
        $message = new Message;
        
        $message->sender_user_id = $senderUserId;
        $message->chat_id = $chatId;
        $message->message = $messageText;

        $message->save();

        return $message;
    }
}
