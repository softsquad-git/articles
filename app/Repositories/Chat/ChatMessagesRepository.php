<?php


namespace App\Repositories\Chat;


use App\Models\Chat\ChatMessage;

class ChatMessagesRepository
{

    /**
     * @param int $messageId
     * @return mixed
     */
    public function findMessage(int $messageId)
    {
        return ChatMessage::find($messageId);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function getMessages(array $params)
    {
        $chatId = $params['chat_id'];
        if (empty($chatId))
            throw new \Exception('Refresh page and try again');
        $messages = ChatMessage::where('chat_id', $chatId);
        return $messages
            ->get();
    }

}
