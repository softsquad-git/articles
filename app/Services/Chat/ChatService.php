<?php

namespace App\Services\Chat;

use App\Models\Chat\Chat;
use Illuminate\Support\Facades\Auth;
use \Exception;

class ChatService
{

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function sendMessage(array $data)
    {
        $data['sender_id'] = Auth::id();
        $message = Chat::create($data);
        if (empty($message))
            throw new Exception('Nie udało się wysłać wiadomości');
        return $message;
    }

}
