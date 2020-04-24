<?php

namespace App\Repositories\User\Friends;

use App\Helpers\FriendshipStatus;
use App\Models\Friends\Friend;
use Illuminate\Support\Facades\Auth;

class FriendRepository
{

    public function getFriends(int $user_id)
    {
        return Friend::where(function ($q) use ($user_id) {
            $q->where(['sender_id' => $user_id]);
            $q->where(['status' => FriendshipStatus::FRIENDS]);
        })
            ->orWhere(function ($q) use ($user_id) {
                $q->where(['recipient_id' => $user_id]);
                $q->where(['status' => FriendshipStatus::FRIENDS]);
            })
            ->with([
                'sender' => function ($q) use ($user_id) {
                    $q->where('id', '!=', $user_id);
                },
                'recipient' => function ($q) use ($user_id) {
                    $q->where('id', '!=', $user_id);
                }
            ])
            ->get();
    }

    public function sentInvitations()
    {
        return Friend::where(['sender_id' => Auth::id(), 'status' => FriendshipStatus::SENT])
            ->with([
                'sender' => function ($q) {
                    $q->where('id', '!=', Auth::id());
                },
                'recipient' => function ($q) {
                    $q->where('id', '!=', Auth::id());
                }
            ])->get();
    }

    public function waitingInvitations()
    {
        return Friend::where(['recipient_id' => Auth::id(), 'status' => FriendshipStatus::SENT])
            ->with([
                'sender' => function ($q) {
                    $q->where('id', '!=', Auth::id());
                },
                'recipient' => function ($q) {
                    $q->where('id', '!=', Auth::id());
                }
            ])->get();
    }

    public function findPivot(int $id)
    {
        return Friend::find($id);
    }

}
