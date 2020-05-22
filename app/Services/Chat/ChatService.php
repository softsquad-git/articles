<?php

namespace App\Services\Chat;

use App\Models\Chat\Chat;
use App\Repositories\Chat\ChatRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use \Exception;

class ChatService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ChatRepository
     */
    private $chatRepository;

    public function __construct(ChatRepository $chatRepository, UserRepository $userRepository)
    {
        $this->chatRepository = $chatRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function store(array $data)
    {
        $senderId = $data['sender_id'];
        $recipientId = $data['recipient_id'];
        $sender = $this->userRepository->findUser($senderId);
        $recipient = $this->userRepository->findUser($recipientId);
        if (empty($sender) || empty($recipient))
            throw new \Exception('Refresh page and try again');
        $chat = $this->chatRepository->checkChat($senderId, $recipientId);
        if (!empty($chat))
            throw new \Exception('Konwersacja już istnieje');
        $nChat = Chat::create($data);
        if (empty($nChat))
            throw new \Exception('Nie udało się utworzyć konwersacji');
        return $nChat;

    }

    /**
     * @param array $data
     * @param int $chatId
     * @return mixed
     * @throws Exception
     */
    public function update(array $data, int $chatId)
    {
        $chat = $this->chatRepository->findChat($chatId);
        if (empty($chat))
            throw new \Exception('Chat not found');
        $chat->update($data);
        return $chat;
    }

    /**
     * @param int $chatId
     * @return mixed
     * @throws Exception
     */
    public function remove(int $chatId)
    {
        $chat = $this->chatRepository->findChat($chatId);
        if (empty($chat))
            throw new \Exception('Chat not found');
        return $chat->delete();
    }
}
