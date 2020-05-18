<?php

namespace App\Repositories\Chat;

use App\Models\Chat\Chat;
use Illuminate\Support\Facades\Auth;

class ChatRepository
{

    public function getMessages()
    {
        return Chat::where('sender_id', Auth::id())
            ->orWhere('recipient_id', Auth::id())
            ->get();
    }

}
