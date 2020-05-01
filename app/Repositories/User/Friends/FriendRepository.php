<?php

namespace App\Repositories\User\Friends;

use App\Helpers\FriendshipStatus;
use App\Models\Friends\Friend;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendRepository
{
    /**
     * @param int $user_id
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function getFriends(int $user_id, $name = '')
    {
        if (empty(User::find($user_id)))
            throw new \Exception(sprintf('User not found'));

        return Friend::where(function ($q) use ($user_id) {
            $q->where(['sender_id' => $user_id]);
            $q->where(['status' => FriendshipStatus::FRIENDS]);
        })
            ->orWhere(function ($q) use ($user_id) {
                $q->where(['recipient_id' => $user_id]);
                $q->where(['status' => FriendshipStatus::FRIENDS]);
            })
            ->with([
                'sender' => function ($q) use ($user_id, $name) {
                    $q->where('id', '!=', $user_id);
                    if (!empty($name)) {
                        $q->whereHas('specificData', function ($query) use ($name) {
                            $query->where(DB::raw("CONCAT(`name`, ' ', `last_name`)"), 'LIKE', "%" . $name . "%");
                        });
                    }
                },
                'recipient' => function ($q) use ($user_id, $name) {
                    $q->where('id', '!=', $user_id);
                    if (!empty($name)) {
                        $q->whereHas('specificData', function ($query) use ($name) {
                            $query->where(DB::raw("CONCAT(`name`, ' ', `last_name`)"), 'LIKE', "%" . $name . "%");
                        });
                    }
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
