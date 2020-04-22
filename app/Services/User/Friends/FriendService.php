<?php

namespace App\Services\User\Friends;

use App\Helpers\FriendshipStatus;
use App\User;
use Illuminate\Support\Facades\Auth;

class FriendService
{
    public function store(int $recipient_id)
    {
        return User::find(Auth::id())
            ->friends()->syncWithoutDetaching($recipient_id, ['status' => FriendshipStatus::SENT]);
    }

}
