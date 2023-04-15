<?php

namespace App\Services;

use App\Models\User;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;

// use Assert\Assertion;

use App\Repositories\UserRepository;
use App\Repositories\ChatRepository;
use App\Repositories\MessageRepository;


//it should wire or handle with traits
use Illuminate\Database\Capsule\Manager as DB;


class UserChatManager 
{
    private User $user;
    private UserRepository $userRepository;
    private ChatRepository $chatRepository;
    private MessageRepository $messageRepository;

    public function __construct(?int $userId, DB $db)
    {
        $this->userRepository = new UserRepository($db);
        $this->chatRepository = new ChatRepository($db);
        $this->messageRepository = new MessageRepository($db);
        if ($userId) {
            $this->user = $this->userRepository->getUserById($userId);
        }
        // Assertion::that($this->user)->notEmpty("User not found, plz create the user");
    }


    public function sendMessage(int $peerId, string $message)
    {
        $chat = $this->chatRepository->getPeerChat($this->user->id, $peerId);

        if (empty($chat)) {
            $chat = $this->chatRepository->addChat($this->user->id, $peerId);
        }

        $this->messageRepository->addMessage($this->user->id, $chat->id, $message);

    }

    //todo add Pager for limit offset
    public function getChatMessages($chatId, $count=100): string
    {
        return $this->messageRepository->getMessagesJson($chatId, $count);
    }

    public function getChatsJson($count = 100): string
    {
        return $this->chatRepository->getChatListJson($this->user->id, $count);
    }
}