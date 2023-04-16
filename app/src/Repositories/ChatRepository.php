<?php

namespace App\Repositories;

use App\Models\Chat;

use Illuminate\Database\Capsule\Manager as DB;

class ChatRepository extends BaseRepository
{
    public function getChatById($id): ?Chat
    {
        return Chat::find($id);
    }

    public function getChatListJson(int $userId, int $count=100): string
    {
        return Chat::where('sender_user_id', $userId)
                    ->orWhere('receiver_user_id', $userId)
                    ->orderBy('updated_at', 'DESC')
                    ->limit($count)
                    ->get()
                    ->toJson();
    }

    public function getChat(int $senderUserId, int $receiverUserId): ?Chat
    {
        return Chat::where(function ($query) use($creatorId, $peerId) {
                        $query->where('sender_user_id', $senderUserId)
                            ->where('receiver_user_id', $receiverUserId);
                    })
                    ->orWhere(function ($query) use($creatorId, $peerId) {
                        $query->where('receiver_user_id', $senderUserId)
                            ->where('sender_user_id', $receiverUserId);
                    })
                    ->get()->pop();
    }

    public function addChat(int $senderUserId, int $receiverUserId): Chat
    {
        $chat = new Chat;   
        $chat->sender_user_id = $senderUserId;
        $chat->receiver_user_id = $receiverUserId;
        $chat->save();
        return $chat;
    }
}
