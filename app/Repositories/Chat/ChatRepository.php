<?php

namespace App\Repositories\Chat;

use App\Models\Chat\Chat;
use Illuminate\Support\Facades\Auth;

class ChatRepository
{
    /**
     * @param int $chatId
     * @return mixed
     */
    public function findChat(int $chatId)
    {
        return Chat::find($chatId);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getConversations(array $params)
    {
        return Chat::where('sender_id', Auth::id())
            ->orWhere('recipient_id', Auth::id())
            ->get();
    }

    public function checkChat(int $senderId, int $recipientId)
    {
        return Chat::where([
            'sender_id' => $senderId,
            'recipient_id' => $recipientId
        ])->first();
    }

}
