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
        return Chat::where('creator_id', $userId)
                    ->orWhere('peer_id', 1)
                    ->orderBy('updated_at', 'DESC')
                    ->limit($count)
                    ->get()
                    ->toJson();
    }

    public function getPeerChat(int $creatorId, int $peerId): ?Chat
    {
        return Chat::where(function ($query) use($creatorId, $peerId) {
                        $query->where('creator_id', $creatorId)
                            ->where('peer_id', $peerId);
                    })
                    ->orWhere(function ($query) use($creatorId, $peerId) {
                        $query->where('peer_id', $creatorId)
                            ->where('creator_id', $peerId);
                    })
                    ->get()->pop();
    }

    public function addChat(int $creatorId, int $peerId): Chat
    {
        $chat = new Chat;   
        $chat->creator_id = $creatorId;
        $chat->peer_id = $peerId;
        $chat->save();
        return $chat;
    }
}
