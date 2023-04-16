<?php

namespace App\Services;

use App\Models\User;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Repositories\UserRepository;
use App\Repositories\ChatRepository;
use App\Repositories\MessageRepository;


//it should wire or handle with traits
use Illuminate\Database\Capsule\Manager as DB;


class UserChatManager 
{
    private User $sender;
    private UserRepository $userRepository;
    private ChatRepository $chatRepository;
    private MessageRepository $messageRepository;

    public function __construct(DB $db, ?int $senderUserId)
    {
        $this->userRepository = new UserRepository($db);
        $this->chatRepository = new ChatRepository($db);
        $this->messageRepository = new MessageRepository($db);
        if ($senderUserId) {
            $this->sender = $this->userRepository->getUserById($senderUserId);
        }
    }

    private function getChat(int $senderId, int $receiverId): Chat {

        $chat = $this->chatRepository->getPeerChat($senderId, $receiverId);
        
        if (empty($chat)) {
            $chat = $this->chatRepository->addChat($senderId, $receiverId);
        }

        return $chat;
    }


    public function sendMessage(int $receiverUserId, string $message)
    {
        $chat = $this->getChat($this->sender->id, $receiverUserId);

        $this->messageRepository->addMessage($this->sender->id, $chat->id, $message);
    }

    //todo add Pager for limit offset
    public function getChatMessages($chatId, Pager $pager= null): string
    {

        return $this->messageRepository->getMessagesJson($chatId, $pager);
    }

    public function getChatsJson(Pager $pager= null): string
    {
        return $this->chatRepository->getChatListJson($this->user->id, $pager);
    }
}