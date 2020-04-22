<?php

namespace App\Repositories\User\Friends;

use App\Helpers\FriendshipStatus;
use App\User;
use Illuminate\Support\Facades\Auth;

class FriendRepository
{

    public function getFriends(?int $status, int $user_id)
    {
        $items = User::find($user_id);
        return $items->get();
    }


}
