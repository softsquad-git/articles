<?php


namespace App\Services\Chat;


use App\Models\Chat\ChatMessage;
use App\Repositories\Chat\ChatMessagesRepository;
use App\Repositories\Chat\ChatRepository;
use Illuminate\Support\Facades\Auth;

class ChatMessageService
{
    /**
     * @var ChatRepository
     */
    private $chatRepository;

    /**
     * @var ChatMessagesRepository
     */
    private $chatMessageRepository;

    public function __construct(ChatMessagesRepository $chatMessagesRepository, ChatRepository $chatRepository)
    {
        $this->chatMessageRepository = $chatMessagesRepository;
        $this->chatRepository = $chatRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        $chatId = $data['chat_id'];
        $chat = $this->chatRepository->findChat($chatId);
        $senderId = $data['sender_id'] = Auth::id();
        if (empty($chat))
            throw new \Exception('Chat not found');
        if ($chat->sender_id != $senderId || $chat->recipient_id != $senderId)
            throw new \Exception('Refresh page and try again');
        $message = ChatMessage::create($data);
        if (empty($message))
            throw new \Exception('Nie udało się utworzyć wiadomości');
        return $message;
    }

    /**
     * @param array $data
     * @param int $messageId
     * @return mixed
     * @throws \Exception
     */
    public function update(array $data, int $messageId)
    {
        $message = $this->chatMessageRepository->findMessage($messageId);
        if (empty($message))
            throw new \Exception('Message not found');
        $message->update($data);
        return $message;
    }

    /**
     * @param int $messageId
     * @return bool|null
     * @throws \Exception
     */
    public function remove(int $messageId): ?bool
    {
        $message = $this->chatMessageRepository->findMessage($messageId);
        if (empty($message))
            throw new \Exception('Message not found');
        return $message->delete();
    }
}
